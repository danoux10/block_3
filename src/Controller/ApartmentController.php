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
		ApartmentRepository    $ApartmentRepository,
		EntityManagerInterface $entityManager,
		Request                $request): Response
	{
		$data = $ApartmentRepository->findAll();//Delete
//		$data = $ApartmentRepository->ApartmentDesc();
		$tableHead = [
			'code postal',
			'ville',
			'addresse',
			'charge',
			'garantie',
			'loyer',
			'select'];
		$Apartment = new Apartment();
		$formApartment = $this->createForm(ApartmentType::class, $Apartment);
		$formApartment->handleRequest($request);
		if ($formApartment->isSubmitted() && $formApartment->isValid()) {
			$entityManager->persist($Apartment);
			$entityManager->flush();
			return $this->redirectToRoute('app_apartment', [], Response::HTTP_SEE_OTHER);
		}
		return $this->render('apartment/index.html.twig', [
			'page_name' => 'Appartement',
			'type_form' => 'Ajouter',
			'form_method' => 'add',
			'heads' => $tableHead,
			'data' => $data,
			'form_Apartment' => $formApartment,
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
		$inventories = $inventoryRepository->ApartmentInventory($id);
		$owners = $ownerRepository->ApartmentOwner($id);
		$contracts = $contractRepository->ApartmentContract($id);
		$contractData = [];
		foreach ($contracts as $contract){
			$tenant = $contract->getTenant();
			$email = $tenant->getEmail();
			$contractData[] =
				[
					'contract'=>$contract,
					'email'=>$email,
				];
		}
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
			'contracts'=>$contractData,
			//form
			'form_method' => 'update',
			'type_form' => 'Mise à jours',
			'form_Apartment' => $apartment_form,
		]);
	}
}
