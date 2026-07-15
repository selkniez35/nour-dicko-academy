<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\MembershipStatus;
use App\Repository\MembershipPlanRepository;
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
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager
    )
    {}
    #[Route('/', name: 'app_membership-plan_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('membership_plan/index.html.twig');
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
        ]);
    }

    #[Route('/tarifs', name: 'app_prices', methods: ['GET'])]
    public function prices(): Response
    {
        $membershipPlans = $this->membershipPlanRepository->findAll();

        return $this->render('membership_plan/prices.html.twig', [
            'membershipPlans' => $membershipPlans,
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

            // 1. Gestion de l'utilisateur (User)
            $user = $this->userRepository->findOneBy(['email' => $email]);
            if (!$user) {
                $user = new User();
                $user->setEmail($email);
                // On génère un mot de passe temporaire car c'est une pré-inscription
                $temporaryPassword = bin2hex(random_bytes(8));
                $user->setPassword($passwordHasher->hashPassword($user, $temporaryPassword));
                $user->setRoles(['ROLE_USER']);
                $this->entityManager->persist($user);
            }

            // 2. Gestion du UserProfile
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
            $membership->setStudentLevel($data['niveau'] ?? null);
            $membership->setPaymentMode($data['mode_paiement'] ?? null);
            $membership->setPaymentMethod($data['moyen_paiement'] ?? null);

            // Gestion des cours sélectionnés (selectedCourses est une relation ManyToMany vers MembershipPlan)
            $selectedCourseValues = $data['cours'] ?? [];
            foreach ($selectedCourseValues as $courseValue) {
                // Recherche par label exact d'abord
                $plan = $this->membershipPlanRepository->findOneBy(['label' => $courseValue]);
                if (!$plan) {
                    // Recherche floue si nécessaire (arabe -> Langue arabe)
                    $plans = $this->membershipPlanRepository->findAll();
                    foreach ($plans as $p) {
                        // On vérifie si le label de l'entité contient la valeur du formulaire
                        // ex: "Langue arabe" contient "arabe"
                        if (stripos($p->getLabel(), $courseValue) !== false) {
                            $plan = $p;
                            break;
                        }
                    }
                }

                if ($plan) {
                    $membership->addSelectedCourse($plan);
                }
            }

            // Gestion de la formule (optionnel, permet de forcer un cours si non coché ou de valider la cohérence)
            $formuleValue = $data['formule'] ?? null;
            if ($formuleValue) {
                $planFormule = $this->membershipPlanRepository->findOneBy(['label' => $formuleValue]);
                if (!$planFormule) {
                    $plans = $this->membershipPlanRepository->findAll();
                    foreach ($plans as $p) {
                        if (stripos($p->getLabel(), $formuleValue) !== false) {
                            $planFormule = $p;
                            break;
                        }
                    }
                }
                if ($planFormule && !$membership->getSelectedCourses()->contains($planFormule)) {
                    $membership->addSelectedCourse($planFormule);
                }
            }

            // Extraction du prix de la formule si possible (optionnel car Membership a un prix par défaut)
            // Mais MembershipPlan a aussi un prix. Ici on garde la logique simple.

            $this->entityManager->persist($userProfile);
            $this->entityManager->persist($membership);
            $this->entityManager->flush();

            $this->addFlash('success', 'Votre demande d\'inscription a bien été envoyée. Nous vous contacterons prochainement.');

            return $this->redirect($this->generateUrl('app_membership-plan_index') . '#inscription');
        }

        return $this->render('membership_plan/registration.html.twig');
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET'])]
    public function contact(): Response
    {
        return $this->render('membership_plan/contact.html.twig');
    }
}
