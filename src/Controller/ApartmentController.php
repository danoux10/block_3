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
	#[Route('/apartment', name: 'app_apartment', methods: ['GET'])]
	public function index(
		ApartmentRepository    $apartmentRepository,
		EntityManagerInterface $entityManager,
		Request                $request): Response
	{
		$data = $apartmentRepository->ApartmentDesc();
		return $this->render('apartment/index.html.twig', [
			'page_name' => 'Appartement',
			'data' => $data,
		]);
	}
	
	#[Route('/apartment/add', name: 'app_apartment_get_add', methods: ['GET'])]
	public function getAdd(
		Request $request,
	): Response
	{
		$apartment = new Apartment();
		$form_apartment = $this->createForm(ApartmentType::class, $apartment, [
			'action' => "/apartment/add",
		]);
		$form_apartment->handleRequest($request);
		return $this->render('controller/form/_apartment.html.twig', [
			'form_name' => 'ajouter',
			'form_apartment' => $form_apartment,
		]);
	}
	
	#[Route('/apartment/add', name: 'app_apartment_add_post', methods: ['POST'])]
	public function postAdd(
		ApartmentRepository    $apartmentRepository,
		EntityManagerInterface $entityManager,
		Request                $request
	)
	{
		$apartment = new Apartment();
		$form_apartment = $this->createForm(ApartmentType::class, $apartment, [
			'action' => "/apartment/add",
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
	
	#[Route('/apartment/{id}', name: 'app_apartment_selected', methods: ['GET'])]
	public function view(
		$id,
		InventoryRepository $inventoryRepository,
		OwnerRepository $ownerRepository,
		ContractRepository $contractRepository,
		Apartment $apartment,
	): Response
	{
		$inventories = $inventoryRepository->ApartmentInventory($id);
		$owners = $ownerRepository->ApartmentOwner($id);
		$contracts = $contractRepository->ApartmentContract($id);
		return $this->render('apartment/selected.html.twig', [
			'page_name' => 'Appartement',
			'apartment' => $apartment,
			'inventories' => $inventories,
			'owners' => $owners,
			'contracts' => $contracts,
		]);
	}
	
	#[Route('/apartment/{id}/edit', name: 'app_apartment_edit_get', methods: ['GET'])]
	public function getEdit(
		$id,
		Apartment $apartment,
		Request $request,
	): Response
	{
		$apartment_form = $this->createForm(ApartmentType::class, $apartment, [
			'action' => "/apartment/$id/edit",
		]);
		$apartment_form->handleRequest($request);
		return $this->render('controller/form/_apartment.html.twig', [
			'form_name' => 'mettre a jour',
			'form_apartment' => $apartment_form,
		]);
	}
	
	#[Route('/apartment/{id}/owner', name: 'app_apartment_edit_owner_get', methods: ['GET'])]
	public function getOwner(
		$id,
		Apartment $apartment,
		Request $request
	): Response
	{
		$owner_form = $this->createForm(ApartOwnerType::class, $apartment, [
			'action' => "/apartment/$id/owner",
		]);
		$owner_form->handleRequest($request);
		return $this->render('controller/form/_apartOwner.html.twig', [
			'form_owner' => $owner_form,
		]);
	}
	#[Route('apartment/{id}/owner', name: 'app_apartment_edit_owner_post', methods: ['POST'])]
	public function postOwner(
		$id,
		Apartment $apartment,
		OwnerRepository $ownerRepository,
		EntityManagerInterface $entityManager,
		Request $request,
	)
	{
		$owner_form = $this->createForm(ApartOwnerType::class, $apartment, [
			'action' => "/apartment/{id}/owner",
		]);
		$owner_form->handleRequest($request);
		if ($owner_form->isSubmitted() && $owner_form->isValid()) {
			$entityManager->persist($apartment,$ownerRepository);
			$entityManager->flush();
			$owners = $ownerRepository->ApartmentOwner($id);
			$data = $this->json([
				'status' => 'success',
				'message'=>'Propriétaire Mis a jour',
				'elements'=>[
					['id'=>'owner-apartment','view'=>$this->render('controller/data-visualizer/owner/_card.html.twig',['owners'=>$owners])->getContent()],
				],
			]);
		}
		return $data;
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
			'action' => "/apartment/$id/inventory",
		]);
		$inventory_form->handleRequest($request);
		return $this->render('controller/form/_inventory.html.twig', [
			'form_inventory' => $inventory_form,
		]);
	}
	
	#[Route('/apartment/{id}/inventory', name: 'app_apartment_add_inventory_post', methods: ['POST'])]
	public function postInventory(
		$id,
		Apartment              $apartment,
		InventoryRepository    $inventoryRepository,
		EntityManagerInterface $entityManager,
		Request                $request,
	)
	{
		$inventory = new Inventory();
		$form_inventory = $this->createForm(InventoryType::class, $inventory, [
			'apartment' => $apartment,
			'action' => "/apartment/{id}/inventory",
		]);
		$form_inventory->handleRequest($request);
		if ($form_inventory->isSubmitted() && $form_inventory->isValid()) {
			$entityManager->persist($inventory);
			$entityManager->flush();
			$inventories = $inventoryRepository->ApartmentInventory($id);
			$data = $this->json([
				'status' => 'success',
				'message' => 'etat des lieux ajouté avec success',
				'elements' => [
					['id' => 'inventory-apartment', 'view' => $this->render('controller/data-visualizer/inventory/_card.html.twig', ['inventories' => $inventories])->getContent(),]
				]
			]);
		}
		return $data;
	}

	#[Route('/inventory/{id}/delete', name:'app_inventory_delete', methods:['POST'])]
	public Function inventoryDelete(
		Request $request,
		Inventory $inventory,
		EntityManagerInterface $entityManager,
	):Response{
		if($this->isCsrfTokenValid('deleteInventory',$inventory->getId(),$request->request->get('_token'))){
			$entityManager->remove($inventory);
			$entityManager->flush();
		}
		return  $this->redirectToRoute('app_apartment',[],Response::HTTP_SEE_OTHER);
	}
	
	#[Route('/apartment/{id}/contract', name: 'app_apartment_add_contract_get', methods: ['GET'])]
	public function getContract(
		$id,
		Apartment $apartment,
		Request $request
	): Response
	{
		$contract = new Contract();
		$contract_form = $this->createForm(ContractType::class, $contract, [
			'apartment' => $apartment,
			'action' => "/apartment/$id/contract",
		]);
		$contract_form->handleRequest($request);
		return $this->render('controller/form/_contrat.html.twig', [
			'name_form' => 'add',
			'form_contract' => $contract_form,
		]);
	}
	
	#[Route('/apartment/{id}/contract', name: 'app_apartment_add_contract_post', methods: ['POST'])]
	public function postContract(
		$id,
		Apartment $apartment,
		ContractRepository $contractRepository,
		EntityManagerInterface $entityManager,
		Request $request,
	)
	{
		$contract = new Contract();
		$contract_form = $this->createForm(ContractType::class, $contract, [
			'apartment' => $apartment,
			'action' => '/apartment/{id}/contract',
		]);
		$contract_form->handleRequest($request);
		if ($contract_form->isSubmitted() && $contract_form->isValid()) {
			$entityManager->persist($contract);
			$entityManager->flush();
			$contracts = $contractRepository->ApartmentContract($id);
			$data = $this->json([
				'status' => 'success',
				'message' => 'Contract ajouté avec success',
				'elements' => [
					['id' => 'contract-apartment',
					'view' => $this->render('controller/data-visualizer/contract/_card.html.twig', ['contracts' => $contracts])->getContent(),]
				]
			]);
		}
		return $data;
	}
	
	
}

