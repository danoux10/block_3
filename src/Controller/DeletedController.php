<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Entity\Inventory;
use App\Entity\Owner;
use App\Entity\Tenant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeletedController extends AbstractController
{
    #[Route('/{id}/deleted/inventory', name: 'app_deleted_inventory', methods: ['POST'])]
    public function deleteInventory(
			Request $request,
	    Inventory $inventory,
	    EntityManagerInterface $entityManager
    ): Response
    {
	    if ($this->isCsrfTokenValid('deleteInventory'.$inventory->getId(), $request->request->get('_token'))) {
		    $entityManager->remove($inventory);
		    $entityManager->flush();
	    }
	    return $this->redirectToRoute('app_apartment', [], Response::HTTP_SEE_OTHER);
    }   
		
		#[Route('/{id}/deleted/apartment', name: 'app_deleted_apartment', methods: ['POST'])]
    public function deleteApartment(
			Request $request,
	    Apartment $apartment,
	    EntityManagerInterface $entityManager
    ): Response
    {
	    if ($this->isCsrfTokenValid('deleteApartment'.$apartment->getId(), $request->request->get('_token'))) {
		    $entityManager->remove($apartment);
		    $entityManager->flush();
	    }
	    return $this->redirectToRoute('app_apartment', [], Response::HTTP_SEE_OTHER);
    }
}
