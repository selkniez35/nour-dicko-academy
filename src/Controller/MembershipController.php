<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Membership;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\DocumentTypeEnum;
use App\Enum\MembershipStatus;
use App\Form\MembershipType;
use App\Service\DocumentUploader;
use App\Service\FileUploader;
use App\Service\SeasonResolver;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/membership')]
class MembershipController extends AbstractController
{    public function __construct(private readonly Security $security){}
    #[Route('/', name: 'app_membership_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $memberships = $em->getRepository(User::class)->findAll();

        return $this->render('membership/index.html.twig', [
            'users' => $memberships,
        ]);
    }

    #[Route('/new', name: 'app_membership_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        FileUploader $uploader,
        SeasonResolver $seasonResolver
    ): Response {

        $user = $this->security->getUser();

        if ($user) {
            $userProfile = $user->getProfile();

            if (!$userProfile) {
                $userProfile = new UserProfile();
                $user->setProfile($userProfile);
            }
        } else {
            $userProfile = new UserProfile();
        }

        // =========================
        // MEMBERSHIP INIT
        // =========================
        $membership = new Membership();
        $membership->setUserProfile($userProfile);

        $season = $seasonResolver->getCurrentSeason();
        $membership->setSeason($season);
        $membership->setStatus(MembershipStatus::PENDING);

        // =========================
        // DOSSIER USER + SEASON
        // =========================
        $firstName = $userProfile->getFirstName();
        $lastName  = strtoupper($userProfile->getLastName());

        $folder = sprintf(
            '%s-%s_%s',
            $firstName,
            $lastName,
            $season
        );

        // =========================
        // DOCUMENTS OBLIGATOIRES
        // =========================
        $membership->addDocument(
            new Document()->setType(DocumentTypeEnum::CERTIFICATE_MEDICAL)
        );

        $membership->addDocument(
            new Document()->setType(DocumentTypeEnum::PIECE_IDENTITY)
        );

        $membership->addDocument(
            new Document()->setType(DocumentTypeEnum::PHOTO_IDENTITY)
        );

        // =========================
        // FORM
        // =========================
        $form = $this->createForm(MembershipType::class, $membership);
        $form->handleRequest($request);

        // =========================
        // SUBMIT
        // =========================
        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($membership->getDocuments() as $index => $document) {

                $formDocument = $form->get('documents')->get($index);
                $file = $formDocument->get('file')->getData();

                if ($file) {

                    $baseName = sprintf(
                        '%s_%s_%s_%s',
                        $firstName,
                        strtolower($lastName),
                        $season,
                        $document->getType()->value
                    );

                    try {
                        $fileName = $uploader->upload(
                            $file,
                            $baseName,
                            $folder
                        );

                        $document->setFilename($fileName);
                        $document->setMembership($membership);

                    } catch (Exception) {
                        $this->addFlash('error', 'Erreur upload document');
                    }
                }
            }

            if ($user) {
                $em->persist($user);
            }

            $em->persist($userProfile);

            $em->persist($membership);
            $em->flush();

            $this->addFlash('success', 'Inscription enregistrée');

            return $this->redirectToRoute('app_pay', [
                'id' => $membership->getId()
            ]);
        }

        return $this->render('membership/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_membership_show', methods: ['GET'])]
    public function show(User $membership): Response
    {
        return $this->render('membership/show.html.twig', [
            'user' => $membership,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_membership_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $membership, EntityManagerInterface $em): Response {

        if (!$membership->getProfile()) {
            $membership->setProfile(new UserProfile());
        }

        $form = $this->createForm(MembershipType::class, $membership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($membership);
            $em->flush();

            $this->addFlash('success', 'Adhésion mise à jour avec succès');

            return $this->redirectToRoute('app_membership_index');
        }

        return $this->render('membership/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $membership,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_membership_delete', methods: ['POST'])]
    public function delete(Request $request, User $membership, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membership->getId(), $request->request->get('_token'))) {

            $em->remove($membership);
            $em->flush();

            $this->addFlash('success', 'Adhésion supprimée');
        }

        return $this->redirectToRoute('app_membership_index');
    }
}