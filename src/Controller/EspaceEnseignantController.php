<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EspaceEnseignantController extends AbstractController
{
    #[Route('/espace-enseignant', name: 'app_espace_enseignant')]
    public function dashboard(): Response
    {
        return $this->render('espace_enseignant/dashboard.html.twig');
    }
}
