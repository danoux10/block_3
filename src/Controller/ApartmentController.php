<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Entity\Contract;
use App\Entity\Inventory;
use App\Entity\Owner;

use App\Form\ApartOwnerType;
use App\Form\ContractType;
use App\Form\FindByCityType;
use App\Form\InventoryType;
use App\Form\ApartmentType;

use App\Repository\ApartmentRepository;
use App\Repository\ContractRepository;
use App\Repository\InventoryRepository;
use App\Repository\OwnerRepository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
		$tableHead = [
//			'id',
			'code postal',
			'ville',
			'addresse',
			'charge',
			'garantie',
			'loyer',
			'select'];
		$data = $apartmentRepository->findAll();//Delete
//		$data = $apartmentRepository->ApartmentDesc();
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
		$inventories = $inventoryRepository->ApartmentInventory($id);
		$owners = $ownerRepository->ApartmentOwner($id);
		$contracts = $contractRepository->ApartmentContract($id);
		$contractData = [];
		foreach ($contracts as $contract) {
			$tenant = $contract->getTenant();
			$email = $tenant->getEmail();
			$contractData[] =
				[
					'contract' => $contract,
					'email' => $email,
				];
		}
		
		
		//forms
		$apartment_form = $this->createForm(ApartmentType::class, $apartment);
		$apartment_form->handleRequest($request);
		if ($apartment_form->isSubmitted() && $apartment_form->isValid()) {
			$entityManager->flush();
			return $this->redirectToRoute('app_apartment_selected', ['id' => $id], Response::HTTP_SEE_OTHER);
		}
		
		$inventory = new Inventory();
		$inventory_form = $this->createForm(InventoryType::class, $inventory, ['apartment'=>$apartment]);
		$inventory_form->handleRequest($request);
		if ($inventory_form->isSubmitted() && $inventory_form->isValid()) {
			$entityManager->persist($inventory);
			$entityManager->flush();
			return $this->redirectToRoute('app_apartment_selected', ['id' => $id], Response::HTTP_SEE_OTHER);
		}
		
		$contract = new Contract();
		$contract_form = $this->createForm(ContractType::class, $contract, ['apartment' => $apartment]);
		$contract_form->handleRequest($request);
		if ($contract_form->isSubmitted() && $contract_form->isValid()) {
			$entityManager->persist($contract);
			$entityManager->flush();
			return $this->redirectToRoute('app_apartment_selected', ['id' => $id], Response::HTTP_SEE_OTHER);
		}
		
		$owner_form = $this->createForm(ApartOwnerType::class, $apartment);
		$owner_form->handleRequest($request);
		if ($owner_form->isSubmitted() && $owner_form->isValid()) {
			$entityManager->persist($apartment);
			$entityManager->flush();
			return $this->redirectToRoute('app_apartment_selected', ['id' => $id], Response::HTTP_SEE_OTHER);
		}
		
		return $this->render('apartment/selected.html.twig', [
			'page_name' => 'Appartement',
			//data
			'apartment' => $apartment,
			'inventories' => $inventories,
			'owners' => $owners,
			'contracts' => $contractData,
			//form
			'form_method' => 'update',
			'type_form' => 'Mise à jours',
			
			'form_apartment' => $apartment_form,
			'form_contract' => $contract_form,
			'form_inventory' => $inventory_form,
			'form_owner' => $owner_form
		]);
	}
}

