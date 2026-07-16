<?php

namespace App\Controller;

use App\Dto\User\UserCreateDto;
use App\Entity\Announcement;
use App\Entity\CourseSession;
use App\Entity\Membership;
use App\Entity\MembershipPlan;
use App\Entity\Payment;
use App\Entity\User;
use App\Enum\MembershipStatus;
use App\Enum\UserRole;
use App\Form\AdminUserType;
use App\Form\AnnouncementType;
use App\Form\CourseSessionType;
use App\Form\MembershipAdminType;
use App\Form\MembershipPlanType;
use App\Form\UserType;
use App\Repository\AnnouncementRepository;
use App\Repository\CourseSessionRepository;
use App\Repository\MembershipPlanRepository;
use App\Repository\MembershipRepository;
use App\Repository\PaymentRepository;
use App\Repository\UserRepository;
use App\Service\MailService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin', name: 'app_admin_')]
#[IsGranted('ROLE_ADMIN')]
final class AdminController extends AbstractController
{
    #[Route('', name: 'dashboard')]
    public function dashboard(UserRepository $userRepository, MembershipRepository $membershipRepository, PaymentRepository $paymentRepository, MembershipPlanRepository $planRepository, AnnouncementRepository $announcementRepository, CourseSessionRepository $courseSessionRepository): Response {

        $courseSessions = $courseSessionRepository->findAllOrdered();

        $studentCreateDto = new UserCreateDto();
        $studentCreateDto->roles = [UserRole::STUDENT->value];
        $teacherCreateDto = new UserCreateDto();
        $teacherCreateDto->roles = [UserRole::TEACHER->value];

        $courseSessionsData = array_map(static function (CourseSession $session): array {
            $teacher = $session->getTeacher();

            return [
                'id' => $session->getId(),
                'date' => $session->getStartsAt()?->format('Y-m-d'),
                'start' => $session->getStartsAt()?->format('H:i'),
                'end' => $session->getEndsAt()?->format('H:i'),
                'label' => $session->getPlan()?->getLabel(),
                'teacher' => $teacher ? trim($teacher->getFirstName() . ' ' . $teacher->getLastName()) : null,
            ];
        }, $courseSessions);

        $plans = $planRepository->findAllOrdered();
        $latestNews = $announcementRepository->findLatest(5);

        $planEditForms = [];
        foreach ($plans as $plan) {
            $planEditForms[$plan->getId()] = $this->createForm(MembershipPlanType::class, $plan)->createView();
        }

        $announcementEditForms = [];
        foreach ($latestNews as $news) {
            $announcementEditForms[$news->getId()] = $this->createForm(AnnouncementType::class, $news)->createView();
        }

        $sessionEditForms = [];
        foreach ($courseSessions as $session) {
            $sessionEditForms[$session->getId()] = $this->createForm(CourseSessionType::class, $session)->createView();
        }

        $allUsers = $userRepository->findAllOrdered();
        $userEditForms = [];
        foreach ($allUsers as $oneUser) {
            $userEditForms[$oneUser->getId()] = $this->createForm(UserType::class, $oneUser)->createView();
        }

        return $this->render('admin/dashboard.html.twig', [
            'stats' => [
                'students' => $userRepository->countStudents(),
                'teachers' => $userRepository->countTeachers(),
                'registrations' => $membershipRepository->countRecent(7),
                'revenue' => $paymentRepository->getTotalPaidAmount(),
            ],
            'paymentStats' => [
                'received' => $paymentRepository->getTotalPaidAmount(),
                'pending' => $paymentRepository->getTotalPendingAmount(),
            ],
            'latestRegistrations' => $membershipRepository->findLatest(5),
            'latestPayments' => $paymentRepository->findLatest(5),
            'latestNews' => $latestNews,
            'students' => $userRepository->findStudents(),
            'teachers' => $userRepository->findTeachers(),
            'allUsers' => $allUsers,
            'availableRoles' => [
                'Étudiant' => UserRole::STUDENT->value,
                'Enseignant' => UserRole::TEACHER->value,
                'Admin' => UserRole::ADMIN->value,
            ],
            'plans' => $plans,
            'pendingMemberships' => $membershipRepository->findPending(20),
            'allMemberships' => $membershipRepository->findAllOrdered(100),
            'courseSessions' => $courseSessions,
            'courseSessionsData' => $courseSessionsData,
            'calendarStats' => [
                'totalSessions' => count($courseSessions),
            ],
            'planNewForm' => $this->createForm(MembershipPlanType::class, new MembershipPlan())->createView(),
            'announcementNewForm' => $this->createForm(AnnouncementType::class, new Announcement())->createView(),
            'sessionNewForm' => $this->createForm(CourseSessionType::class, new CourseSession())->createView(),
            'studentNewForm' => $this->createForm(AdminUserType::class, $studentCreateDto)->createView(),
            'teacherNewForm' => $this->createForm(AdminUserType::class, $teacherCreateDto)->createView(),
            'planEditForms' => $planEditForms,
            'announcementEditForms' => $announcementEditForms,
            'sessionEditForms' => $sessionEditForms,
            'userEditForms' => $userEditForms,
        ]);
    }

    #[Route('/students', name: 'students')]
    public function students(): Response
    {
        return $this->redirectToDashboardSection('eleves');
    }

    #[Route('/teachers', name: 'teachers')]
    public function teachers(): Response
    {
        return $this->redirectToDashboardSection('enseignants');
    }

    #[Route('/trainings', name: 'trainings')]
    public function trainings(): Response
    {
        return $this->redirectToDashboardSection('classes');
    }

    #[Route('/registrations', name: 'registrations')]
    public function registrations(): Response
    {
        return $this->redirectToDashboardSection('inscriptions');
    }

    #[Route('/payments', name: 'payments')]
    public function payments(): Response
    {
        return $this->redirectToDashboardSection('paiements');
    }

    #[Route('/news', name: 'news')]
    public function news(): Response
    {
        return $this->redirectToDashboardSection('actualites');
    }

    #[Route('/students/new', name: 'student_new')]
    public function studentNew(Request $request, UserService $userService): Response
    {

        return $this->handleUserCreate($request, $userService, [UserRole::STUDENT->value], 'Ajouter un élève', 'app_admin_students');
    }

    #[Route('/teachers/new', name: 'teacher_new')]
    public function teacherNew(Request $request, UserService $userService): Response
    {
        return $this->handleUserCreate($request, $userService, [UserRole::TEACHER->value], 'Ajouter un enseignant', 'app_admin_teachers');
    }

    #[Route('/users/{id}/edit', name: 'user_edit')]
    public function userEdit(Request $request, User $user, EntityManagerInterface $entityManager, Security $security): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Si l'admin modifie son propre compte, on rafraîchit le token de
            // sécurité pour éviter que Symfony ne le déconnecte (les données de
            // sécurité de l'utilisateur en session ne correspondraient plus).
            if ($user === $this->getUser()) {
                $security->login($user);
            }

            $this->addFlash('success', 'Utilisateur mis à jour.');

            return $this->redirectToDashboardSection('utilisateurs');
        }

        return $this->render('admin/form.html.twig', [
            'title' => 'Modifier un utilisateur',
            'back_route' => 'app_admin_dashboard',
            'submit_label' => 'Enregistrer',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/users/{id}/delete', name: 'user_delete', methods: ['POST'])]
    public function userDelete(Request $request, User $user, CourseSessionRepository $courseSessionRepository, EntityManagerInterface $entityManager): Response
    {
        $this->verifyCsrfOrDeny('delete-user-' . $user->getId(), $request);

        if (!$user->getPayments()->isEmpty()) {
            $this->addFlash('error', 'Impossible de supprimer cet utilisateur tant qu’il a des paiements associés.');

            return $this->redirectToDashboardSection('utilisateurs');
        }

        if ($courseSessionRepository->countForTeacher($user) > 0) {
            $this->addFlash('error', 'Impossible de supprimer cet utilisateur car il est assigné comme enseignant à des séances.');

            return $this->redirectToDashboardSection('utilisateurs');
        }

        return $this->removeAndRedirect($user, $entityManager, 'Utilisateur supprimé.', $this->redirectToDashboardSection('utilisateurs'));
    }

    #[Route('/users/{id}/role', name: 'user_role_update', methods: ['POST'])]
    public function userRoleUpdate(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $this->verifyCsrfOrDeny('change-role-' . $user->getId(), $request);

        if ($user === $this->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez pas modifier votre propre rôle.');

            return $this->redirectToRoute('app_admin_dashboard', [], Response::HTTP_SEE_OTHER);
        }

        $role = (string) $request->request->get('role');
        $validRoles = array_map(static fn (UserRole $r): string => $r->value, UserRole::cases());

        if (!in_array($role, $validRoles, true)) {
            $this->addFlash('error', 'Rôle invalide.');

            return $this->redirectToRoute('app_admin_dashboard', [], Response::HTTP_SEE_OTHER);
        }

        $user->setRoles([$role]);
        $entityManager->flush();

        $this->addFlash('success', 'Rôle mis à jour.');

        return $this->redirectToRoute('app_admin_dashboard', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/trainings/new', name: 'plan_new')]
    public function planNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->handleMembershipPlanForm($request, new MembershipPlan(), $entityManager, 'Ajouter une formation');
    }

    #[Route('/trainings/{id}/edit', name: 'plan_edit')]
    public function planEdit(Request $request, MembershipPlan $membershipPlan, EntityManagerInterface $entityManager): Response
    {
        return $this->handleMembershipPlanForm($request, $membershipPlan, $entityManager, 'Modifier une formation');
    }

    #[Route('/trainings/{id}/delete', name: 'plan_delete', methods: ['POST'])]
    public function planDelete(Request $request, MembershipPlan $membershipPlan, MembershipRepository $membershipRepository, CourseSessionRepository $courseSessionRepository, EntityManagerInterface $entityManager): Response
    {
        $this->verifyCsrfOrDeny('delete-plan-' . $membershipPlan->getId(), $request);

        if ($membershipRepository->countForPlan($membershipPlan) > 0) {
            $this->addFlash('error', 'Impossible de supprimer cette formation car elle est utilisée par des inscriptions.');

            return $this->redirectToRoute('app_admin_trainings');
        }

        if ($courseSessionRepository->countForPlan($membershipPlan) > 0) {
            $this->addFlash('error', 'Impossible de supprimer cette formation car des séances sont programmées pour elle.');

            return $this->redirectToRoute('app_admin_trainings');
        }

        return $this->removeAndRedirect($membershipPlan, $entityManager, 'Formation supprimée.', $this->redirectToRoute('app_admin_trainings'));
    }

    #[Route('/registrations/{id}/edit', name: 'membership_edit')]
    public function membershipEdit(Request $request, Membership $membership, EntityManagerInterface $entityManager, MailService $mailService): Response
    {
        $previousStatus = $membership->getStatus();

        $form = $this->createForm(MembershipAdminType::class, $membership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            if ($membership->getStatus() !== $previousStatus) {
                if ($membership->getStatus() === MembershipStatus::ACTIVE) {
                    $mailService->sendMembershipApproved($membership);
                } elseif ($membership->getStatus() === MembershipStatus::SUSPENDED) {
                    $mailService->sendMembershipRejected($membership);
                }
            }

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
        $this->verifyCsrfOrDeny('delete-membership-' . $membership->getId(), $request);

        return $this->removeAndRedirect($membership, $entityManager, 'Inscription supprimée.', $this->redirectToRoute('app_admin_registrations'));
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
        $this->verifyCsrfOrDeny('delete-announcement-' . $announcement->getId(), $request);

        return $this->removeAndRedirect($announcement, $entityManager, 'Actualité supprimée.', $this->redirectToRoute('app_admin_news'));
    }

    #[Route('/payments/{id}', name: 'payment_show', requirements: ['id' => '\d+'])]
    public function paymentShow(Payment $payment): Response
    {
        return $this->render('admin/payment_show.html.twig', [
            'payment' => $payment,
        ]);
    }

    #[Route('/sessions/new', name: 'session_new')]
    public function sessionNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->handleCourseSessionForm($request, new CourseSession(), $entityManager, 'Ajouter une séance');
    }

    #[Route('/sessions/{id}/edit', name: 'session_edit', requirements: ['id' => '\d+'])]
    public function sessionEdit(Request $request, CourseSession $courseSession, EntityManagerInterface $entityManager): Response
    {
        return $this->handleCourseSessionForm($request, $courseSession, $entityManager, 'Modifier une séance');
    }

    #[Route('/sessions/{id}/delete', name: 'session_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function sessionDelete(Request $request, CourseSession $courseSession, EntityManagerInterface $entityManager): Response
    {
        $this->verifyCsrfOrDeny('delete-session-' . $courseSession->getId(), $request);

        return $this->removeAndRedirect($courseSession, $entityManager, 'Séance supprimée.', $this->redirectToDashboardSection('calendrier'));
    }

    private function handleUserCreate(Request $request, UserService $userService, array $roles, string $title, string $backRoute): Response
    {
        $dto = new UserCreateDto();
        $dto->roles = $roles;

        $form = $this->createForm(AdminUserType::class, $dto);

        return $this->handleAdminForm($request, $form, function () use ($userService, $dto, $backRoute) {
            $userService->createUser($dto);
            $this->addFlash('success', 'Utilisateur créé.');

            return $this->redirectToRoute($backRoute);
        }, $title, $backRoute, 'Créer');
    }

    private function handleMembershipPlanForm(Request $request, MembershipPlan $membershipPlan, EntityManagerInterface $entityManager, string $title): Response
    {
        $form = $this->createForm(MembershipPlanType::class, $membershipPlan);

        return $this->handleAdminForm($request, $form, function () use ($entityManager, $membershipPlan) {
            $entityManager->persist($membershipPlan);
            $entityManager->flush();
            $this->addFlash('success', 'Formation enregistrée.');

            return $this->redirectToRoute('app_admin_trainings');
        }, $title, 'app_admin_trainings');
    }

    private function handleAnnouncementForm(Request $request, Announcement $announcement, EntityManagerInterface $entityManager, string $title, string $backRoute): Response
    {
        $form = $this->createForm(AnnouncementType::class, $announcement);

        return $this->handleAdminForm($request, $form, function () use ($entityManager, $announcement, $backRoute) {
            $entityManager->persist($announcement);
            $entityManager->flush();
            $this->addFlash('success', 'Actualité enregistrée.');

            return $this->redirectToRoute($backRoute);
        }, $title, $backRoute);
    }

    private function handleCourseSessionForm(Request $request, CourseSession $courseSession, EntityManagerInterface $entityManager, string $title): Response
    {
        $form = $this->createForm(CourseSessionType::class, $courseSession);

        return $this->handleAdminForm($request, $form, function () use ($entityManager, $courseSession) {
            $entityManager->persist($courseSession);
            $entityManager->flush();
            $this->addFlash('success', 'Séance enregistrée.');

            return $this->redirectToDashboardSection('calendrier');
        }, $title, 'app_admin_dashboard');
    }

    /**
     * Squelette commun à tous les formulaires admin : soumission + validation,
     * puis délégation de l'action de sauvegarde à $onValid, ou ré-affichage du
     * formulaire avec les erreurs sinon.
     */
    private function handleAdminForm(Request $request, FormInterface $form, callable $onValid, string $title, string $backRoute, string $submitLabel = 'Enregistrer'): Response
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $onValid();
        }

        return $this->render('admin/form.html.twig', [
            'title' => $title,
            'back_route' => $backRoute,
            'submit_label' => $submitLabel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Vérifie le jeton CSRF d'une action de suppression, ou refuse l'accès.
     */
    private function verifyCsrfOrDeny(string $tokenId, Request $request): void
    {
        if (!$this->isCsrfTokenValid($tokenId, (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }
    }

    /**
     * Supprime une entité et redirige avec un message de succès — squelette
     * commun à toutes les actions de suppression admin.
     */
    private function removeAndRedirect(object $entity, EntityManagerInterface $entityManager, string $successMessage, Response $redirect): Response
    {
        $entityManager->remove($entity);
        $entityManager->flush();

        $this->addFlash('success', $successMessage);

        return $redirect;
    }

    /**
     * Redirige vers le tableau de bord en ouvrant directement la section voulue
     * (les sections sont affichées côté client via le hash de l'URL).
     */
    private function redirectToDashboardSection(string $section): Response
    {
        return $this->redirect($this->generateUrl('app_admin_dashboard') . '#' . $section);
    }
}
