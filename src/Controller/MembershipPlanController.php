<?php

namespace App\Controller;

use App\Repository\MembershipPlanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('')]
class MembershipPlanController extends AbstractController
{

    public function __construct(private readonly MembershipPlanRepository $membershipPlanRepository)
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

    #[Route('/contact', name: 'app_contact', methods: ['GET'])]
    public function contact(): Response
    {
        return $this->render('membership_plan/contact.html.twig');
    }
}
