<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EspaceEleveController extends AbstractController
{
    #[Route('/espace-eleve', name: 'app_espace_eleve')]
    public function dashboard(): Response
    {
        return $this->render('espace_eleve/dashboard.html.twig');
    }
}
