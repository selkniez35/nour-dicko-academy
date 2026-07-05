<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('')]
class MembershipPlanController extends AbstractController
{
   #[Route('/', name: 'app_membership-plan_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('membership_plan/index.html.twig');
    }
}