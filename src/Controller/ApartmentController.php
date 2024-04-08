<?php

namespace App\Controller;

use App\Entity\Apartment;

use App\Form\ApartmentType;

use App\Repository\ApartmentRepository;
use App\Repository\ContractRepository;
use App\Repository\InventoryRepository;
use App\Repository\OwnerRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApartmentController extends AbstractController
{
	#[Route('/', name: 'app_apartment', methods: ['GET', 'POST'])]
	public function index(
		ApartmentRepository    $apartmentRepository,
		EntityManagerInterface $entityManager,
		Request                $request): Response
	{
		$data = $apartmentRepository->findAll();//Delete
//		$data = $apartmentRepository->ApartmentDesc();
		$tableHead = [
			'code postal',
			'ville',
			'adresse',
			'charge',
			'garantie',
			'loyer',
			'select'];
		$apartment = new Apartment();
		$formApartment = $this->createForm(ApartmentType::class, $apartment);
		$formApartment->handleRequest($request);
		if ($formApartment->isSubmitted() && $formApartment->isValid()) {
			$entityManager->persist($apartment);
			$entityManager->flush();
			return $this->redirectToRoute('app_apartment', [], Response::HTTP_SEE_OTHER);
		}
		return $this->render('apartment/index.html.twig', [
			'page_name' => 'Appartement',
			'type_form' => 'Ajouter',
			'form_method' => 'add',
			'heads' => $tableHead,
			'data' => $data,
			'form_apartment' => $formApartment,
		]);
	}
	
	#[Route('/{id}/edit', name: 'app_apartment_selected', methods: ['GET', 'POST'])]
	public function view(
		$id,
		InventoryRepository $inventoryRepository,
		OwnerRepository $ownerRepository,
		ContractRepository $contractRepository,
		Apartment $apartment,
		Request $request,
		EntityManagerInterface $entityManager,
	): Response
	{
		//get data
		$inventories = $inventoryRepository->apartmentInventory($id);
		$owners = $ownerRepository->apartmentOwner($id);
		$contracts = $contractRepository->apartmentContract($id);
		//forms
		$apartment_form = $this->createForm(ApartmentType::class, $apartment);
		$apartment_form->handleRequest($request);
		if ($apartment_form->isSubmitted() && $apartment_form->isValid()) {
			$entityManager->flush();
			return $this->redirectToRoute('app_apartment_selected', ['id'=>$id], Response::HTTP_SEE_OTHER);
		}
		return $this->render('apartment/selected.html.twig', [
			'page_name' => 'Appartement',
			//data
			'apartment' => $apartment,
			'inventories' => $inventories,
			'owners'=>$owners,
			'contracts'=>$contracts,
			//form
			'form_method' => 'update',
			'type_form' => 'Mise à jours',
			'form_apartment' => $apartment_form,
		]);
	}
}
