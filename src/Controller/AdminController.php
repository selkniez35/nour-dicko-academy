<?php

namespace App\Controller;

use App\Dto\User\UserCreateDto;
use App\Entity\Announcement;
use App\Entity\Membership;
use App\Entity\MembershipPlan;
use App\Entity\Payment;
use App\Entity\User;
use App\Enum\UserRole;
use App\Form\AdminUserType;
use App\Form\AnnouncementType;
use App\Form\MembershipAdminType;
use App\Form\MembershipPlanType;
use App\Form\UserType;
use App\Repository\AnnouncementRepository;
use App\Repository\MembershipPlanRepository;
use App\Repository\MembershipRepository;
use App\Repository\PaymentRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin', name: 'app_admin_')]
#[IsGranted('ROLE_ADMIN')]
final class AdminController extends AbstractController
{
    #[Route('', name: 'dashboard')]
    public function dashboard(
        UserRepository $userRepository,
        MembershipRepository $membershipRepository,
        PaymentRepository $paymentRepository,
        MembershipPlanRepository $planRepository,
        AnnouncementRepository $announcementRepository
    ): Response {
        return $this->render('admin/dashboard.html.twig', [
            'stats' => [
                'students' => $userRepository->countStudents(),
                'teachers' => $userRepository->countTeachers(),
                'registrations' => $membershipRepository->countPending(),
                'revenue' => $paymentRepository->getTotalPaidAmount(),
            ],
            'latestRegistrations' => $membershipRepository->findLatest(5),
            'latestPayments' => $paymentRepository->findLatest(5),
            'latestPlans' => $planRepository->findLatest(5),
            'latestNews' => $announcementRepository->findLatest(5),
        ]);
    }

    #[Route('/students', name: 'students')]
    public function students(UserRepository $userRepository): Response
    {
        return $this->render('admin/partials/_students.html.twig', [
            'students' => $userRepository->findStudents(),
        ]);
    }

    #[Route('/teachers', name: 'teachers')]
    public function teachers(UserRepository $userRepository): Response
    {
        return $this->render('admin/partials/_teachers.html.twig', [
            'teachers' => $userRepository->findTeachers(),
        ]);
    }

    #[Route('/trainings', name: 'trainings')]
    public function trainings(MembershipPlanRepository $planRepository): Response
    {
        return $this->render('admin/partials/_trainings.html.twig', [
            'plans' => $planRepository->findAllOrdered(),
        ]);
    }

    #[Route('/registrations', name: 'registrations')]
    public function registrations(MembershipRepository $membershipRepository): Response
    {
        return $this->render('admin/partials/_registrations.html.twig', [
            'memberships' => $membershipRepository->findLatest(20),
        ]);
    }

    #[Route('/payments', name: 'payments')]
    public function payments(PaymentRepository $paymentRepository): Response
    {
        return $this->render('admin/partials/_payments.html.twig', [
            'payments' => $paymentRepository->findLatest(20),
        ]);
    }

    #[Route('/news', name: 'news')]
    public function news(AnnouncementRepository $announcementRepository): Response
    {
        return $this->render('admin/partials/_news.html.twig', [
            'announcements' => $announcementRepository->findLatest(20),
        ]);
    }

    #[Route('/students/new', name: 'student_new')]
    public function studentNew(Request $request, UserService $userService): Response
    {

        return $this->handleUserCreate($request, $userService, [UserRole::USER->value], 'Ajouter un élève', 'app_admin_students');
    }

    #[Route('/teachers/new', name: 'teacher_new')]
    public function teacherNew(Request $request, UserService $userService): Response
    {
        return $this->handleUserCreate($request, $userService, [UserRole::COACH->value], 'Ajouter un enseignant', 'app_admin_teachers');
    }

    #[Route('/users/{id}/edit', name: 'user_edit')]
    public function userEdit(Request $request, User $user, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();

            if (is_string($plainPassword) && trim($plainPassword) !== '') {
                $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
            }

            $entityManager->flush();
            $this->addFlash('success', 'Utilisateur mis à jour.');

            return $this->redirectToRoute($this->getUserBackRoute($user));
        }

        return $this->render('admin/form.html.twig', [
            'title' => 'Modifier un utilisateur',
            'back_route' => $this->getUserBackRoute($user),
            'submit_label' => 'Enregistrer',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/users/{id}/delete', name: 'user_delete', methods: ['POST'])]
    public function userDelete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete-user-' . $user->getId(), (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        if (!$user->getPayments()->isEmpty()) {
            $this->addFlash('error', 'Impossible de supprimer cet utilisateur tant qu’il a des paiements associés.');

            return $this->redirectToRoute($this->getUserBackRoute($user));
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Utilisateur supprimé.');

        return $this->redirectToRoute($this->getUserBackRoute($user));
    }

    #[Route('/trainings/new', name: 'plan_new')]
    public function planNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->handleMembershipPlanForm($request, new MembershipPlan(), $entityManager, 'Ajouter une formation', 'app_admin_trainings');
    }

    #[Route('/trainings/{id}/edit', name: 'plan_edit')]
    public function planEdit(Request $request, MembershipPlan $membershipPlan, EntityManagerInterface $entityManager): Response
    {
        return $this->handleMembershipPlanForm($request, $membershipPlan, $entityManager, 'Modifier une formation', 'app_admin_trainings');
    }

    #[Route('/trainings/{id}/delete', name: 'plan_delete', methods: ['POST'])]
    public function planDelete(Request $request, MembershipPlan $membershipPlan, MembershipRepository $membershipRepository, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete-plan-' . $membershipPlan->getId(), (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        if ($membershipRepository->countForPlan($membershipPlan) > 0) {
            $this->addFlash('error', 'Impossible de supprimer cette formation car elle est utilisée par des inscriptions.');

            return $this->redirectToRoute('app_admin_trainings');
        }

        $entityManager->remove($membershipPlan);
        $entityManager->flush();

        $this->addFlash('success', 'Formation supprimée.');

        return $this->redirectToRoute('app_admin_trainings');
    }

    #[Route('/registrations/{id}/edit', name: 'membership_edit')]
    public function membershipEdit(Request $request, Membership $membership, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MembershipAdminType::class, $membership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Inscription mise à jour.');

            return $this->redirectToRoute('app_admin_registrations');
        }

        return $this->render('admin/form.html.twig', [
            'title' => 'Modifier une inscription',
            'back_route' => 'app_admin_registrations',
            'submit_label' => 'Enregistrer',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/registrations/{id}/delete', name: 'membership_delete', methods: ['POST'])]
    public function membershipDelete(Request $request, Membership $membership, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete-membership-' . $membership->getId(), (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        $entityManager->remove($membership);
        $entityManager->flush();

        $this->addFlash('success', 'Inscription supprimée.');

        return $this->redirectToRoute('app_admin_registrations');
    }

    #[Route('/news/new', name: 'announcement_new')]
    public function announcementNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->handleAnnouncementForm($request, new Announcement(), $entityManager, 'Publier une actualité', 'app_admin_news');
    }

    #[Route('/news/{id}/edit', name: 'announcement_edit')]
    public function announcementEdit(Request $request, Announcement $announcement, EntityManagerInterface $entityManager): Response
    {
        return $this->handleAnnouncementForm($request, $announcement, $entityManager, 'Modifier une actualité', 'app_admin_news');
    }

    #[Route('/news/{id}/delete', name: 'announcement_delete', methods: ['POST'])]
    public function announcementDelete(Request $request, Announcement $announcement, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete-announcement-' . $announcement->getId(), (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        $entityManager->remove($announcement);
        $entityManager->flush();

        $this->addFlash('success', 'Actualité supprimée.');

        return $this->redirectToRoute('app_admin_news');
    }

    #[Route('/payments/{id}', name: 'payment_show')]
    public function paymentShow(Payment $payment): Response
    {
        return $this->render('admin/payment_show.html.twig', [
            'payment' => $payment,
        ]);
    }

    private function handleUserCreate(Request $request, UserService $userService, array $roles, string $title, string $backRoute): Response
    {
        $dto = new UserCreateDto();
        $dto->roles = $roles;

        $form = $this->createForm(AdminUserType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userService->createUser($dto);
            $this->addFlash('success', 'Utilisateur créé.');

            return $this->redirectToRoute($backRoute);
        }

        return $this->render('admin/form.html.twig', [
            'title' => $title,
            'back_route' => $backRoute,
            'submit_label' => 'Créer',
            'form' => $form->createView(),
        ]);
    }

    private function handleMembershipPlanForm(Request $request, MembershipPlan $membershipPlan, EntityManagerInterface $entityManager, string $title, string $backRoute): Response
    {
        $form = $this->createForm(MembershipPlanType::class, $membershipPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($membershipPlan);
            $entityManager->flush();

            $this->addFlash('success', 'Formation enregistrée.');

            return $this->redirectToRoute($backRoute);
        }

        return $this->render('admin/form.html.twig', [
            'title' => $title,
            'back_route' => $backRoute,
            'submit_label' => 'Enregistrer',
            'form' => $form->createView(),
        ]);
    }

    private function handleAnnouncementForm(Request $request, Announcement $announcement, EntityManagerInterface $entityManager, string $title, string $backRoute): Response
    {
        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($announcement);
            $entityManager->flush();

            $this->addFlash('success', 'Actualité enregistrée.');

            return $this->redirectToRoute($backRoute);
        }

        return $this->render('admin/form.html.twig', [
            'title' => $title,
            'back_route' => $backRoute,
            'submit_label' => 'Enregistrer',
            'form' => $form->createView(),
        ]);
    }

    private function getUserBackRoute(User $user): string
    {
        return in_array(UserRole::COACH->value, $user->getRoles(), true)
            ? 'app_admin_teachers'
            : 'app_admin_students';
    }
}
