<?php

namespace App\Controller;

use App\Entity\CourseSession;
use App\Entity\Recording;
use App\Entity\User;
use App\Service\RecordingUploadService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/recordings')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class RecordingController extends AbstractController
{
    #[Route('/{id}/stream', name: 'app_recording_stream', requirements: ['id' => '\d+'])]
    public function watch(Recording $recording, RecordingUploadService $storage): BinaryFileResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $this->assertCanView($recording, $user);

        $response = new BinaryFileResponse($storage->getFilePath($recording));
        $response->headers->set('Content-Type', $recording->getMimeType() ?: 'video/mp4');
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $recording->getOriginalFilename());

        return $response;
    }

    #[Route('/{id}/delete', name: 'app_recording_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(
        Request $request,
        Recording $recording,
        RecordingUploadService $storage,
        EntityManagerInterface $entityManager,
    ): Response {
        /** @var User $user */
        $user = $this->getUser();
        $this->assertCanManage($recording->getCourseSession(), $user);

        if (!$this->isCsrfTokenValid('delete-recording-' . $recording->getId(), (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        $storage->delete($recording);
        $entityManager->remove($recording);
        $entityManager->flush();

        $this->addFlash('success', 'Vidéo supprimée.');

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('app_admin_dashboard') . '#calendrier');
        }

        return $this->redirect($this->generateUrl('app_espace_enseignant') . '#enregistrements');
    }

    private function assertCanManage(?CourseSession $session, User $user): void
    {
        if ($session && ($this->isGranted('ROLE_ADMIN') || $session->getTeacher() === $user)) {
            return;
        }

        throw $this->createAccessDeniedException();
    }

    private function assertCanView(Recording $recording, User $user): void
    {
        $session = $recording->getCourseSession();

        if ($session && (
            $this->isGranted('ROLE_ADMIN')
            || $session->getTeacher() === $user
            || $session->getStudents()->contains($user)
        )) {
            return;
        }

        throw $this->createAccessDeniedException();
    }
}
