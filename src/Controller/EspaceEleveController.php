<?php

namespace App\Controller;

use App\Entity\CourseSession;
use App\Entity\User;
use App\Enum\MembershipStatus;
use App\Repository\CourseSessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EspaceEleveController extends AbstractController
{
    #[Route('/espace-eleve', name: 'app_espace_eleve')]
    public function dashboard(CourseSessionRepository $courseSessionRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $sessions = $courseSessionRepository->findForStudent($user);

        $sessionsData = array_map(static function (CourseSession $session): array {
            return [
                'id' => $session->getId(),
                'date' => $session->getStartsAt()?->format('Y-m-d'),
                'start' => $session->getStartsAt()?->format('H:i'),
                'end' => $session->getEndsAt()?->format('H:i'),
                'label' => $session->getPlan()?->getLabel(),
                'teacher' => $session->getTeacher()?->getProfile()?->getFullName(),
            ];
        }, $sessions);

        $membership = null;
        $profile = $user->getProfile();
        if ($profile) {
            foreach ($profile->getMemberships() as $oneMembership) {
                if ($oneMembership->getStatus() === MembershipStatus::ACTIVE) {
                    $membership = $oneMembership;
                    break;
                }
            }
            $membership ??= $profile->getMemberships()->first() ?: null;
        }

        return $this->render('espace_eleve/dashboard.html.twig', [
            'membership' => $membership,
            'sessions' => $sessions,
            'sessionsData' => $sessionsData,
        ]);
    }
}
