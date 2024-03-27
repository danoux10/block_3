<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TenantController extends AbstractController
{
    #[Route('/tenant', name: 'app_tenant')]
    public function index(): Response
    {
        return $this->render('tenant/index.html.twig', [
            'controller_name' => 'TenantController',
        ]);
    }
}
