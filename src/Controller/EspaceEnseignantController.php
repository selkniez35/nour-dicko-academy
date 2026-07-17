<?php

namespace App\Controller;

use App\Entity\CourseSession;
use App\Entity\User;
use App\Repository\CourseSessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EspaceEnseignantController extends AbstractController
{
    #[Route('/espace-enseignant', name: 'app_espace_enseignant')]
    public function dashboard(CourseSessionRepository $courseSessionRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $sessions = $courseSessionRepository->findForTeacher($user);

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
        ]);
    }
}
