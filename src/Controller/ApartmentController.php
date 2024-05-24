<?php /** @noinspection ALL */

namespace App\Controller;

use App\Entity\Apartment;
use App\Entity\Contract;
use App\Entity\Inventory;
use App\Entity\Owner;

use App\Form\ApartOwnerType;
use App\Form\ContractType;
use App\Form\InventoryType;
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
use Knp\Component\Pager\PaginatorInterface;

class ApartmentController extends AbstractController
{
	#[Route('/', name: 'app_apartment', methods: ['GET'])]
	public function index(
		ApartmentRepository    $apartmentRepository,
		EntityManagerInterface $entityManager,
		Request                $request): Response
	{
//		$data = $apartmentRepository->findAll();//Delete
		$data = $apartmentRepository->ApartmentDesc();
//		if ($formApartment->isSubmitted() && $formApartment->isValid()) {
//			$entityManager->persist($apartment);
//			$apartment->calculateTotalCharge();
//			$entityManager->flush();
//			dd($apartment);
//			return $this->redirectToRoute('app_apartment', [], Response::HTTP_SEE_OTHER);
//		}
		return $this->render('apartment/index.html.twig', [
			'page_name' => 'Appartement',
			'data' => $data,
		]);
	}
	
	#[Route('/add', name: 'app_apartment_get_add', methods: ['GET'])]
	public function getAdd(
		Request $request,
	): Response
	{
		$apartment = new Apartment();
		$form_apartment = $this->createForm(ApartmentType::class, $apartment, [
			'action' => "/add",
		]);
		$form_apartment->handleRequest($request);
		return $this->render('controller/form/_apartment.html.twig', [
			'form_name' => 'ajouter',
			'form_apartment' => $form_apartment,
		]);
	}
	
	#[Route('/add', name: 'app_apartment_add_post', methods: ['POST'])]
	public function postAdd(
		ApartmentRepository    $apartmentRepository,
		EntityManagerInterface $entityManager,
		Request                $request
	)
	{
		$apartment = new Apartment();
		$form_apartment = $this->createForm(ApartmentType::class, $apartment, [
			'action' => "/add",
		]);
		$form_apartment->handleRequest($request);
		if ($form_apartment->isSubmitted() && $form_apartment->isValid()) {
			$entityManager->persist($apartment);
			$apartment->calculateTotalCharge();
			$entityManager->flush();
			$apartments = $apartmentRepository->ApartmentDesc();
			$data = $this->json([
				'status' => 'success',
				'message' => 'Ajouter',
				'elements' => [
					[
						'id' => 'apartment-all',
						'view' => $this->render('controller/data-visualizer/apartment/_table.html.twig', ['data' => $apartments])->getContent(),
					],
				]
			]);
		}
		return $data;
	}
	
	#[Route('apartment/{id}', name: 'app_apartment_selected', methods: ['GET'])]
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
		
		//forms
//		$inventory = new Inventory();
//
//		if ($inventory_form->isSubmitted() && $inventory_form->isValid()) {
//			$entityManager->persist($inventory);
//			$entityManager->flush();
//			return $this->redirectToRoute('app_apartment_selected', ['id' => $id], Response::HTTP_SEE_OTHER);
//		}

//		$contract = new Contract();
//		$contract_form = $this->createForm(ContractType::class, $contract, ['apartment' => $apartment]);
//		$contract_form->handleRequest($request);
//		if ($contract_form->isSubmitted() && $contract_form->isValid()) {
//			$entityManager->persist($contract);
//			$entityManager->flush();
//			return $this->redirectToRoute('app_apartment_selected', ['id' => $id], Response::HTTP_SEE_OTHER);
//		}

//		if ($owner_form->isSubmitted() && $owner_form->isValid()) {
//			$entityManager->persist($apartment);
//			$entityManager->flush();
//			return $this->redirectToRoute('app_apartment_selected', ['id' => $id], Response::HTTP_SEE_OTHER);
//		}
		return $this->render('apartment/selected.html.twig', [
			'page_name' => 'Appartement',
			
			'apartment' => $apartment,
			'inventories' => $inventories,
			'owners' => $owners,
			'contracts' => $contracts,
		]);
	}
	
	#[Route('apartment/{id}/edit', name: 'app_apartment_edit_get', methods: ['GET'])]
	public function getEdit(
		$id,
		Apartment $apartment,
		Request $request,
	): Response
	{
		$apartment_form = $this->createForm(ApartmentType::class, $apartment, [
			'action' => "apartment/$id/edit",
		]);
		$apartment_form->handleRequest($request);
		return $this->render('controller/form/_apartment.html.twig', [
			'form_name' => 'mettre a jour',
			'form_apartment' => $apartment_form,
		]);
	}
	
	#[Route('apartment/{id}/owner', name: 'app_apartment_edit_owner_get', methods: ['GET'])]
	public function getOwner(
		$id,
		Apartment $apartment,
		Request $request
	): Response
	{
		$owner_form = $this->createForm(ApartOwnerType::class, $apartment, [
			'action' => "/$id/owner",
		]);
		$owner_form->handleRequest($request);
		return $this->render('controller/form/_apartOwner.html.twig', [
			'form_owner' => $owner_form,
		]);
	}
	
	#[Route('apartment/{id}/inventory', name: 'app_apartment_add_inventory_get', methods: ['GET'])]
	public function getInventory(
		$id,
		Apartment $apartment,
		Request $request
	): Response
	{
		$inventory = new Inventory();
		$inventory_form = $this->createForm(InventoryType::class, $inventory, [
			'apartment' => $apartment,
			'action' => 'apartment/{id}/inventory',
		]);
		$inventory_form->handleRequest($request);
		return $this->render('controller/form/_inventory.html.twig', [
			'form_inventory' => $inventory_form,
		]);
	}
	
	#[Route('apartment/{id}/contract', name: 'app_apartment_add_contract_get', methods: ['GET'])]
	public function getContract(
		$id,
		Apartment $apartment,
		Request $request
	): Response
	{
		$contract = new Contract();
		$contract_form = $this->createForm(ContractType::class, $contract, [
			'apartment' => $apartment,
			'action' => '/{id}/contract',
		]);
		$contract_form->handleRequest($request);
		return $this->render('controller/form/_contrat.html.twig', [
			'name_form'=>'add',
			'form_contract' => $contract_form,
		]);
	}
	
	//edit Post

//	#[Route('/{id}/owner', name: 'app_apartment_owner_get', methods: ['GET'])]
//	public function getOwner(
//		$id,
//		Apartment $apartment,
//		Request $request
//	)
//	{
//		$owner_form = $this->createForm(ApartOwnerType::class, $apartment);
//		$owner_form->handleRequest($request);
//
//		return $this->render('controller/form/_apartOwner.html.twig', [
//			'form_name' => 'mettre a jour',
//			'form_apartment' => $owner_form,
//		]);
//	}
}

