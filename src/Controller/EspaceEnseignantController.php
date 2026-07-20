<?php

namespace App\Controller;

use App\Entity\CourseSession;
use App\Entity\Recording;
use App\Entity\User;
use App\Form\RecordingType;
use App\Repository\CourseSessionRepository;
use App\Service\RecordingUploadService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_TEACHER')]
class EspaceEnseignantController extends AbstractController
{
    #[Route('/espace-enseignant', name: 'app_espace_enseignant')]
    public function dashboard(CourseSessionRepository $courseSessionRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $sessions = $courseSessionRepository->findForTeacher($user);

        $recordingUploadForms = [];
        foreach ($sessions as $session) {
            $recordingUploadForms[$session->getId()] = $this->createForm(RecordingType::class, new Recording())->createView();
        }

        $sessionsData = array_map(static function (CourseSession $session): array {
            return [
                'id' => $session->getId(),
                'date' => $session->getStartsAt()?->format('Y-m-d'),
                'start' => $session->getStartsAt()?->format('H:i'),
                'end' => $session->getEndsAt()?->format('H:i'),
                'label' => $session->getPlan()?->getLabel(),
            ];
        }, $sessions);

        $plans = [];
        $students = [];
        foreach ($sessions as $session) {
            $plan = $session->getPlan();
            if ($plan) {
                $plans[$plan->getId()] = $plan;
            }
            foreach ($session->getStudents() as $student) {
                $students[$student->getId()] = $student;
            }
        }

        return $this->render('espace_enseignant/dashboard.html.twig', [
            'sessions' => $sessions,
            'sessionsData' => $sessionsData,
            'plans' => array_values($plans),
            'students' => array_values($students),
            'recordingUploadForms' => $recordingUploadForms,
        ]);
    }

    #[Route('/espace-enseignant/sessions/{id}/recordings/new', name: 'app_espace_enseignant_recording_new', requirements: ['id' => '\d+'])]
    public function recordingNew(
        Request $request,
        CourseSession $courseSession,
        EntityManagerInterface $entityManager,
        RecordingUploadService $recordingStorage,
    ): Response {
        /** @var User $user */
        $user = $this->getUser();

        if ($courseSession->getTeacher() !== $user) {
            throw $this->createAccessDeniedException();
        }

        $recording = new Recording();
        $form = $this->createForm(RecordingType::class, $recording);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('file')->getData();

            $recording = $recordingStorage->store($courseSession, $uploadedFile, $user, $recording->getTitle());
            $entityManager->persist($recording);
            $entityManager->flush();

            $this->addFlash('success', 'Vidéo mise en ligne.');
        } else {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('error', $error->getMessage());
            }
        }

        return $this->redirect($this->generateUrl('app_espace_enseignant') . '#enregistrements');
    }
}
