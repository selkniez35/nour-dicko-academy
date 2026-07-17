<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Entity\MembershipPlan;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\MembershipStatus;
use App\Enum\PaymentMethod;
use App\Enum\PaymentModeEnum;
use App\Enum\StudentLevelEnum;
use App\Repository\MembershipPlanRepository;
use App\Repository\MembershipRepository;
use App\Repository\UserProfileRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('')]
class MembershipPlanController extends AbstractController
{

    public function __construct(
        private readonly MembershipPlanRepository $membershipPlanRepository,
        private readonly MembershipRepository $membershipRepository,
        private readonly UserRepository $userRepository,
        private readonly UserProfileRepository $userProfileRepository,
        private readonly EntityManagerInterface $entityManager
    )
    {}
    #[Route('/', name: 'app_membership-plan_index', methods: ['GET'])]
    public function index(): Response
    {
        $membershipPlans = $this->membershipPlanRepository->findAll();

        return $this->render('membership_plan/index.html.twig', [
            'membershipPlans' => $membershipPlans,
            'fullPlanIds' => $this->getFullPlanIds($membershipPlans),
            'fullFormules' => $this->getFullFormules(),
            'studentLevels' => StudentLevelEnum::cases(),
            'paymentModes' => PaymentModeEnum::cases(),
            'paymentMethods' => [PaymentMethod::BANK_TRANSFER, PaymentMethod::CASH],
        ]);
    }

    #[Route('/a-propos', name: 'app_about', methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('membership_plan/about.html.twig');
    }

    #[Route('/actualites', name: 'app_news', methods: ['GET'])]
    public function news(): Response
    {
        return $this->render('membership_plan/news.html.twig');
    }

    #[Route('/cours', name: 'app_courses', methods: ['GET'])]
    public function courses(): Response
    {
        $membershipPlans = $this->membershipPlanRepository->findAll();

        return $this->render('membership_plan/courses.html.twig', [
            'membershipPlans' => $membershipPlans,
            'fullPlanIds' => $this->getFullPlanIds($membershipPlans),
        ]);
    }

    #[Route('/tarifs', name: 'app_prices', methods: ['GET'])]
    public function prices(): Response
    {
        $membershipPlans = $this->membershipPlanRepository->findAll();

        return $this->render('membership_plan/prices.html.twig', [
            'membershipPlans' => $membershipPlans,
            'fullPlanIds' => $this->getFullPlanIds($membershipPlans),
        ]);
    }

    #[Route('/inscription', name: 'app_registration', methods: ['GET', 'POST'])]
    public function registration(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('inscription', (string) $request->request->get('_token'))) {
                $this->addFlash('error', 'Session expirée, merci de renvoyer le formulaire.');

                return $this->redirect($this->generateUrl('app_membership-plan_index') . '#inscription');
            }

            $data = $request->request->all();
            $email = $data['email'] ?? null;

            if (!$email) {
                $this->addFlash('error', 'L\'adresse e-mail est obligatoire.');

                return $this->redirect($this->generateUrl('app_membership-plan_index') . '#inscription');
            }

            $phone = $data['telephone'] ?? null;

            // Une personne qui a déjà un compte (ex: inscrite à un autre cours) doit pouvoir
            // s'inscrire à l'académie à nouveau : on réutilise son compte au lieu de bloquer.
            $user = $this->userRepository->findOneBy(['email' => $email]);

            // En revanche, si ce numéro de téléphone appartient au profil d'un AUTRE compte,
            // on ne peut pas y rattacher cette inscription (conflit réel entre deux personnes).
            if ($phone) {
                $existingProfileForPhone = $this->userProfileRepository->findOneBy(['phoneNumber' => $phone]);
                if ($existingProfileForPhone && (!$user || $existingProfileForPhone->getUser() !== $user)) {
                    $this->addFlash('error', 'Un compte existe déjà avec ce numéro de téléphone.');

                    return $this->redirect($this->generateUrl('app_membership-plan_index') . '#inscription');
                }
            }

            // 1. Récupération ou création de l'utilisateur (User)
            if (!$user) {
                $user = new User();
                $user->setEmail($email);
                // On génère un mot de passe temporaire car c'est une pré-inscription
                $temporaryPassword = bin2hex(random_bytes(8));
                $user->setPassword($passwordHasher->hashPassword($user, $temporaryPassword));
                $user->setRoles(['ROLE_STUDENT']);
                $this->entityManager->persist($user);
            }

            // 2. Récupération ou création du UserProfile
            $userProfile = $user->getProfile();
            if (!$userProfile) {
                $userProfile = new UserProfile();
                $userProfile->setUser($user);
            }

            $userProfile->setLastName($data['nom'] ?? $userProfile->getLastName());
            $userProfile->setFirstName($data['prenom'] ?? $userProfile->getFirstName());
            if (!empty($data['date_naissance'])) {
                $userProfile->setDateOfBirth(new \DateTime($data['date_naissance']));
            }
            $userProfile->setGender($data['sexe'] ?? $userProfile->getGender());
            $userProfile->setPhoneNumber($data['telephone'] ?? $userProfile->getPhoneNumber());

            // 3. Création de la Membership (Inscription)
            $membership = new Membership();
            $membership->setUserProfile($userProfile);
            $membership->setSeason(date('Y') . '-' . (date('Y') + 1));
            $membership->setStatus(MembershipStatus::PENDING);
            $membership->setStudentLevel(isset($data['niveau']) ? StudentLevelEnum::tryFrom($data['niveau']) : null);
            $membership->setPaymentMode(isset($data['mode_paiement']) ? PaymentModeEnum::tryFrom($data['mode_paiement']) : null);
            $membership->setPaymentMethod(isset($data['moyen_paiement']) ? PaymentMethod::tryFrom($data['moyen_paiement']) : null);

            // Gestion des cours sélectionnés (selectedCourses est une relation ManyToMany vers MembershipPlan)
            $allPlans = $this->membershipPlanRepository->findAll();
            $resolvedPlans = [];

            foreach ($data['cours'] ?? [] as $courseValue) {
                $plan = $this->resolvePlan($courseValue, $allPlans);
                if ($plan) {
                    $resolvedPlans[$plan->getId()] = $plan;
                }
            }

            // Gestion de la formule (optionnel, permet de forcer un cours si non coché ou de valider la cohérence)
            $formuleValue = $data['formule'] ?? null;
            if ($formuleValue) {
                $planFormule = $this->resolvePlan($formuleValue, $allPlans);
                if ($planFormule) {
                    $resolvedPlans[$planFormule->getId()] = $planFormule;
                }
            }

            // On bloque l'inscription si un des cours sélectionnés a atteint son nombre maximum d'inscrits
            foreach ($resolvedPlans as $plan) {
                if ($plan->isFull($this->membershipRepository->countStudentsForPlan($plan))) {
                    $this->addFlash('error', sprintf('Le cours "%s" a atteint son nombre maximum d\'inscrits. Merci de choisir une autre formule.', $plan->getLabel()));

                    return $this->redirect($this->generateUrl('app_membership-plan_index') . '#inscription');
                }
            }

            foreach ($resolvedPlans as $plan) {
                $membership->addSelectedCourse($plan);
            }

            // Extraction du prix de la formule si possible (optionnel car Membership a un prix par défaut)
            // Mais MembershipPlan a aussi un prix. Ici on garde la logique simple.

            $this->entityManager->persist($userProfile);
            $this->entityManager->persist($membership);
            $this->entityManager->flush();

            $this->addFlash('success', 'Votre demande d\'inscription a bien été envoyée. Nous vous contacterons prochainement.');

            return $this->redirect($this->generateUrl('app_membership-plan_index') . '#inscription');
        }

        return $this->render('membership_plan/registration.html.twig', [
            'fullFormules' => $this->getFullFormules(),
            'studentLevels' => StudentLevelEnum::cases(),
            'paymentModes' => PaymentModeEnum::cases(),
            'paymentMethods' => [PaymentMethod::BANK_TRANSFER, PaymentMethod::CASH],
        ]);
    }

    /**
     * @return string[] Valeurs de "formule" (arabe, coran, ...) dont la formation correspondante a atteint son nombre maximum d'inscrits
     */
    private function getFullFormules(): array
    {
        $allPlans = $this->membershipPlanRepository->findAll();
        $fullFormules = [];
        foreach (['arabe', 'education', 'coran', 'pack-arabe', 'pack-coran'] as $formuleValue) {
            $plan = $this->resolvePlan($formuleValue, $allPlans);
            if ($plan && $plan->isFull($this->membershipRepository->countStudentsForPlan($plan))) {
                $fullFormules[] = $formuleValue;
            }
        }

        return $fullFormules;
    }

    /**
     * Résout la valeur brute d'un champ de formulaire (ex: "arabe") vers l'entité MembershipPlan
     * correspondante : correspondance exacte du label d'abord, puis correspondance floue (contient).
     *
     * @param MembershipPlan[] $plans
     */
    private function resolvePlan(string $value, array $plans): ?MembershipPlan
    {
        foreach ($plans as $plan) {
            if ($plan->getLabel() === $value) {
                return $plan;
            }
        }

        foreach ($plans as $plan) {
            if (stripos($plan->getLabel(), $value) !== false) {
                return $plan;
            }
        }

        return null;
    }

    /**
     * @param MembershipPlan[] $plans
     * @return int[] Identifiants des formations ayant atteint leur nombre maximum d'inscrits
     */
    private function getFullPlanIds(array $plans): array
    {
        $fullPlanIds = [];
        foreach ($plans as $plan) {
            if ($plan->isFull($this->membershipRepository->countStudentsForPlan($plan))) {
                $fullPlanIds[] = $plan->getId();
            }
        }

        return $fullPlanIds;
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET'])]
    public function contact(): Response
    {
        return $this->render('membership_plan/contact.html.twig');
    }
}
