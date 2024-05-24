<?php

namespace App\Controller;

use App\Entity\Tenant;

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
		TenantRepository       $TenantRepository,
		EntityManagerInterface $entityManager,
		Request                $request
	): Response
	{
		$data = $TenantRepository->findAll();//delete
//		$data = $TenantRepository->TenantDesc();
		$tableHead = [
			'nom',
			'prénom',
			'email',
			'téléphone',
			'addresse',
			'apl',
			'valeur apl',
			'select'
		];
//		$Tenant = new Tenant();
//		$formTenant = $this->createForm(TenantType::class, $Tenant);
//		$formTenant->handleRequest($request);
//		if ($formTenant->isSubmitted() && $formTenant->isValid()) {
//			$entityManager->persist($Tenant);
//			$entityManager->flush();
//			return $this->redirectToRoute('app_tenant', [], Response::HTTP_SEE_OTHER);
//		}
		return $this->render('tenant/index.html.twig', [
			'page_name' => 'locataire',
			'heads' => $tableHead,
			'data' => $data,
//			'form_tenant' => $formTenant,
		]);
	}

//	#[Route('/tenant/add',name:'app_tenant_add_get',methods: ['GET'])]
//	public function getAdd(
//		Request $request,
//	):Response{
//		$tenant = new Tenant();
//		$tenant_form = $this->createForm(TenantType::class,$tenant,[
//			'action'=>'tenant/add',
//		]);
//		$tenant_form->handleRequest($request);
//		return $this->render('controller/form/_tenant.html.twig',[
//			'form_name'=>'ajouter',
//			'form_tenant'=>$tenant_form,
//		]);
//	}
	#[Route('/tenant/{id}', name: 'app_tenant_selected', methods: ['GET', 'POST'])]
	public function view(
		$id,
		Tenant $tenant,
		TenantRepository $TenantRepository,
		ContractRepository $contractRepository,
		EntityManagerInterface $entityManager,
		Request $request
	): Response
	{
		//get data
		$contracts = $contractRepository->TenantContract($id);
		//form
		$tenant_form = $this->createForm(TenantType::class, $tenant);
		$tenant_form->handleRequest($request);
		if ($tenant_form->isSubmitted() && $tenant_form->isValid()) {
			$entityManager->flush();
			return $this->redirectToRoute('app_tenant_selected', ['id' => $id], Response::HTTP_SEE_OTHER);
		}
		
		return $this->render('tenant/selected.html.twig', [
			'page_name' => 'propriétaire',
			'type_form' => 'modifier',
			'form_Tenant' => $tenant_form,
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
}
