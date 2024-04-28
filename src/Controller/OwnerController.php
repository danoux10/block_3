<?php

namespace App\Controller;

use App\Entity\Owner;
use App\Form\Owner\OwnerApartmentType;
use App\Form\OwnerType;
use App\Repository\ApartmentRepository;
use App\Repository\OwnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OwnerController extends AbstractController
{
	#[Route('/owner', name: 'app_owner', methods: ['GET', 'POST'])]
	public function index(
		OwnerRepository        $OwnerRepository,
		EntityManagerInterface $entityManager,
		Request                $request
	): Response
	{
		$data = $OwnerRepository->findAll();//delete
//		$data = $OwnerRepository->OwnerDesc();
		$tableHead = [
			'nom',
			'prénom',
			'email',
			'téléphone',
			'adresse',
			'select'
		];
		$Owner = new Owner();
		$formOwner = $this->createForm(OwnerType::class, $Owner);
		$formOwner->handleRequest($request);
		if ($formOwner->isSubmitted() && $formOwner->isValid()) {
			$entityManager->persist($Owner);
			$entityManager->flush();
			return $this->redirectToRoute('app_owner', [], Response::HTTP_SEE_OTHER);
		}
		return $this->render('owner/index.html.twig', [
			'page_name' => 'propriétaire',
			'type_form' => 'Ajouter',
			'heads' => $tableHead,
			'data' => $data,
			'form_owner' => $formOwner,
		]);
	}
	
	#[Route('/owner/{id}/edit', name: 'app_owner_selected', methods: ['GET', 'POST'])]
	public function view(
		$id,
		Owner $owner,
		ApartmentRepository $ApartmentRepository,
		EntityManagerInterface $entityManager,
		Request $request
	): Response
	{
		//get data
		$apartments = $ApartmentRepository->OwnerApartment($id);
		//form
		$owner_form = $this->createForm(OwnerType::class, $owner);
		$owner_form->handleRequest($request);
		if ($owner_form->isSubmitted() && $owner_form->isValid()) {
			$entityManager->flush();
			return $this->redirectToRoute('app_owner_selected', ['id' => $id], Response::HTTP_SEE_OTHER);
		}
		
		return $this->render('owner/selected.html.twig', [
			'page_name' => 'propriétaire',
			'type_form' => 'Modifier',
			'form_Owner' => $owner_form,
			'owner' => $owner,
			'apartments' => $apartments,
		]);
	}
}
