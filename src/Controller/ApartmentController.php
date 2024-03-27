<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApartmentController extends AbstractController
{
    #[Route('/apartment', name: 'app_apartment')]
    public function index(): Response
    {
        return $this->render('apartment/index.html.twig', [
            'controller_name' => 'ApartmentController',
        ]);
    }
}
