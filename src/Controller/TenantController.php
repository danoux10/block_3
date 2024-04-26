<?php

namespace App\Controller;

use App\Entity\Tenant;
use App\Form\TenantType;
use App\Repository\ContractRepository;
use App\Repository\TenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TenantController extends AbstractController
{
	#[Route('/tenant', name: 'app_tenant', methods: ['GET', 'POST'])]
	public function index(
		TenantRepository        $TenantRepository,
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
		$Tenant = new Tenant();
		$formTenant = $this->createForm(TenantType::class, $Tenant);
		$formTenant->handleRequest($request);
		if ($formTenant->isSubmitted() && $formTenant->isValid()) {
			$entityManager->persist($Tenant);
			$entityManager->flush();
			return $this->redirectToRoute('app_tenant', [], Response::HTTP_SEE_OTHER);
		}
		return $this->render('tenant/index.html.twig', [
			'page_name' => 'locataire',
			'type_form' => 'Ajouter',
			'form_method' => 'add',
			'heads' => $tableHead,
			'data' => $data,
			'form_Tenant' => $formTenant,
		]);
	}
	
	#[Route('/tenant/{id}/edit', name: 'app_tenant_selected', methods: ['GET', 'POST'])]
	public function view(
		$id,
		Tenant $tenant,
		TenantRepository        $TenantRepository,
		ContractRepository $contractRepository,
		EntityManagerInterface $entityManager,
		Request                $request
	): Response
	{
		//get data
		//form
		$tenant_form = $this->createForm(TenantType::class,$tenant);
		$tenant_form->handleRequest($request);
		$contracts = $contractRepository->TenantContract($id);
		$contractsData =[];
		foreach ($contracts as $contract){
			$apartment = $contract->getApartment();
			$address = $apartment->getAddress();
			$city = $apartment->getCity();
			$contractsData[]=[
				'contract' => $contract,
				'address' => $address,
				'city' => $city,
			];
		}
		if ($tenant_form->isSubmitted()&&$tenant_form->isValid()){
			$entityManager->flush();
			return $this->redirectToRoute('app_tenant_selected',['id'=>$id],Response::HTTP_SEE_OTHER);
		}
		
		return $this->render('tenant/selected.html.twig', [
			'page_name' => 'propriétaire',
			'type_form' => 'modifier',
			'form_method' => 'modifier',
			'form_Tenant' => $tenant_form,
			'tenant'=>$tenant,
			'contracts'=>$contractsData,
		]);
	}
}
