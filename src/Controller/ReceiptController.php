<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReceiptController extends AbstractController
{
    #[Route('/receipt', name: 'app_receipt')]
    public function index(): Response
    {
        return $this->render('receipt/index.html.twig', [
            'controller_name' => 'ReceiptController',
        ]);
    }
}
