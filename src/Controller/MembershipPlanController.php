<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Membership;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Enum\DocumentTypeEnum;
use App\Enum\MembershipStatus;
use App\Form\MembershipType;
use App\Repository\MembershipPlanRepository;
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

#[Route('/membershipPlan')]
class MembershipPlanController extends AbstractController
{    public function __construct(private readonly MembershipPlanRepository $membershipPlanRepository){}
    #[Route('/', name: 'app_membership-plan_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('membership_plan/index.html.twig', [
            'plans' => $this->membershipPlanRepository->findAll()
        ]);
    }
}