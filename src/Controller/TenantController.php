<?php

namespace App\Controller;

use App\Entity\Tenant;
use App\Form\TenantType;
use App\Repository\ContractRepository;
use App\Repository\TenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TenantController extends AbstractController
{
	#[Route('/tenant', name: 'app_tenant', methods: ['GET', 'POST'])]
	public function index(
		TenantRepository       $tenantRepository,
		EntityManagerInterface $entityManager,
		Request                $request
	): Response
	{
		$data = $tenantRepository->findAll();//delete
//		$data = $tenantRepository->TenantDesc();
		$tableHead = [
			'nom',
			'prénom',
			'email',
			'téléphone',
			'adresse',
			'utilisation apl',
			'apl',
			'select'
		];
		$tenant = new Tenant();
		$formTenant = $this->createForm(TenantType::class,$tenant);
		$formTenant->handleRequest($request);
		if($formTenant->isSubmitted() && $formTenant->isValid()){
			$entityManager->persist($tenant);
			$entityManager->flush();
			return $this->redirectToRoute('app_tenant', [], Response::HTTP_SEE_OTHER);
		}
		return $this->render('tenant/index.html.twig', [
			'page_name' => 'tenant',
			'type_form' => 'Ajouter',
			'form_method' => 'add',
			'heads' => $tableHead,
			'data' => $data,
			'form_tenant'=>$formTenant
		]);
	}
	#[Route('/tenant/{id}/edit', name: 'app_tenant_selected', methods: ['GET', 'POST'])]
	public function view(
		$id,
		Tenant $tenant,
		TenantRepository       $tenantRepository,
		ContractRepository $contractRepository,
		EntityManagerInterface $entityManager,
		Request                $request
	): Response
	{
		//data
		$contracts = $contractRepository->tenantContract($id);
		//form
		$formTenant = $this->createForm(TenantType::class,$tenant);
		$formTenant->handleRequest($request);
		if($formTenant->isSubmitted() && $formTenant->isValid()){
			$entityManager->flush();
			return $this->redirectToRoute('app_tenant_selected', ['id'=>$id], Response::HTTP_SEE_OTHER);
		}
		return $this->render('tenant/selected.html.twig', [
			'page_name' => 'tenant',
			'type_form' => 'Modifier',
			'form_method' => 'update',
			'form_tenant'=>$formTenant,
			
			'tenant'=>$tenant,
			'contracts'=>$contracts,
		]);
	}
}
