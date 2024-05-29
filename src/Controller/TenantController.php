<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\Tenant;

use App\Form\ContractType;
use App\Form\TenantType;

use App\Repository\ContractRepository;
use App\Repository\TenantRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TenantController extends AbstractController
{
	#[Route('/tenant', name: 'app_tenant', methods: ['GET'])]
	public function index(
		TenantRepository $TenantRepository,
	): Response
	{
		$data = $TenantRepository->TenantDesc();
		return $this->render('tenant/index.html.twig', [
			'page_name' => 'locataire',
			'data' => $data,
		]);
	}
	
	#[Route('/tenant/add', name: 'app_tenant_add_get', methods: ['GET'])]
	public function getAdd(
		Request $request,
	): Response
	{
		$tenant = new Tenant();
		$tenant_form = $this->createForm(TenantType::class, $tenant, [
			'action' => '/tenant/add',
		]);
		$tenant_form->handleRequest($request);
		return $this->render('controller/form/_tenant.html.twig', [
			'form_name' => 'ajouter',
			'form_tenant' => $tenant_form,
		]);
	}
	
	#[Route('/tenant/add', name: 'app_tenant_add_post', methods: ['POST'])]
	public function postAdd(
		TenantRepository       $tenantRepository,
		EntityManagerInterface $entityManager,
		Request                $request,
	)
	{
		$tenant = new Tenant();
		$tenant_form = $this->createForm(TenantType::class, $tenant, [
			'action' => '/tenant/add',
		]);
		$tenant_form->handleRequest($request);
		if ($tenant_form->isSubmitted() && $tenant_form->isValid()) {
			$entityManager->persist($tenant);
			$entityManager->flush();
			$tenants = $tenantRepository->TenantDesc();
			$data = $this->json([
				'status' => 'success',
				'message' => 'Ajouter',
				'elements' => [
					[
						'id' => 'tenant-all',
						'view' => $this->render('controller/data-visualizer/tenant/_table.html.twig', ['data' => $tenants])->getContent(),
					],
				]
			]);
		}
		return $data;
	}
	
	#[Route('/tenant/{id}', name: 'app_tenant_selected', methods: ['GET'])]
	public function view(
		$id,
		Tenant $tenant,
		ContractRepository $contractRepository,
	): Response
	{
		$contracts = $contractRepository->TenantContract($id);
		
		return $this->render('tenant/selected.html.twig', [
			'page_name' => 'propriétaire',
			'tenant' => $tenant,
			'contracts' => $contracts,
		]);
	}
	
	#[Route('/tenant/{id}/edit', name: 'app_tenant_edit_get', methods: ['GET'])]
	public function getEdit(
		$id,
		Tenant $tenant,
		Request $request
	): Response
	{
		$tenant_form = $this->createForm(TenantType::class, $tenant, [
			'action' => "/tenant/$id/edit",
		]);
		$tenant_form->handleRequest($request);
		return $this->render('controller/form/_tenant.html.twig', [
			'form_name' => 'Mettre à jour',
			'form_tenant' => $tenant_form,
		]);
	}
	
	#[Route('/tenant/{id}/edit', name: 'app_tenant_edit_post', methods: ['POST'])]
	public function postEdit(
		Tenant                 $tenant,
		EntityManagerInterface $entityManager,
		Request                $request
	): JsonResponse
	{
		$tenant_form = $this->createForm(TenantType::class, $tenant, [
			'action' => '/tenant/{id}/edit',
		]);
		$tenant_form->handleRequest($request);
		if ($tenant_form->isSubmitted() && $tenant_form->isValid()) {
			$entityManager->flush();
			$data = $this->json([
				'status' => 'success',
				'message' => 'Mis a jours ok',
				'elements' => [
					[
						'id' => 'tenant-selected',
						'view' => $this->render('controller/data-visualizer/tenant/_selected.html.twig', ['tenant' => $tenant])->getContent(),
					],
				],
			]);
		}
		return $data;
	}

	#[Route('/tenant/{id}/contract', name: 'app_tenant_contract_get', methods: ['GET'])]
	public function TenantContractGet(
		$id,
		Tenant $tenant,
		Request $request,
	){
		$contract = new Contract();
		$contract_form = $this->createForm(ContractType::class, $contract, [
			'tenant' => $tenant,
			'action' => "/tenant/$id/contract",
		]);
		$contract_form->handleRequest($request);
		return $this->render('controller/form/_contrat.html.twig', [
			'name_form' => 'add',
			'form_contract' => $contract_form,
		]);
	}
	
	#[Route('/tenant/{id}/contract', name: 'app_tenant_contract_post', methods: ['POST'])]
	public function TenantContractPost(
		$id,
		Tenant $tenant,
		ContractRepository $contractRepository,
		EntityManagerInterface $entityManager,
		Request $request,
	)
	{
		$contract = new Contract();
		$contract_form = $this->createForm(ContractType::class, $contract, [
			'tenant' => $tenant,
			'action' => '/apartment/{id}/contract',
		]);
		$contracts = $contractRepository->TenantContract($id);
		$contract_form->handleRequest($request);
		if ($contract_form->isSubmitted() && $contract_form->isValid()) {
			$entityManager->persist($contract);
			$entityManager->flush();
			$data = $this->json([
				'status' => 'success',
				'message' => 'Contract ajouter avec success',
				'elements' => [
					['id' => 'contract-tenant',
					'view' => $this->render('controller/data-visualizer/contract/_card.html.twig', ['contracts' => $contracts])->getContent(),]
				]
			]);
		}
		return $data;
	}
}
