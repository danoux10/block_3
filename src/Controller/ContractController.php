<?php

namespace App\Controller;

use App\Entity\Contract;

use App\Entity\Payment;
use App\Entity\PaymentType;
use App\Form\ContractType;

use App\Form\ReceiptType;
use App\Repository\ApartmentRepository;
use App\Repository\PaymentTypeRepository;
use App\Repository\TenantRepository;
use App\Repository\ContractRepository;
use App\Repository\PaymentRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContractController extends AbstractController
{
	#[Route('/contract', name: 'app_contract', methods: ['GET'])]
	public function index(
		ContractRepository $contractRepository,
	): Response
	{
		$data = $contractRepository->findAllJoin();
		return $this->render('contract/index.html.twig', [
			'page_name' => 'contract',
			'data' => $data,
		]);
	}
	
	#[Route('/contract/{id}', name: 'app_contract_selected', methods: ['GET'])]
	public function view(
		$id,
		Contract $contract,
		PaymentRepository $paymentRepository,
		ApartmentRepository $ApartmentRepository,
		TenantRepository $TenantRepository,
	): Response
	{
		$apartment = $ApartmentRepository->ContractApartment($id);
		$tenant = $TenantRepository->ContractTenant($id);
		$payments = $paymentRepository->contractPayment($id);
		
		return $this->render('contract/selected.html.twig', [
			'page_name' => 'contract',
			'contract' => $contract,
			'apartment' => $apartment,
			'tenant' => $tenant,
			'payments' => $payments,
		]);
	}
	
	#[Route('/contract/{id}/payments', name: 'app_contract_payments', methods: ['GET'])]
	public function generatePayment(
		$id,
		Contract $contract,
		EntityManagerInterface $entityManager,
		PaymentRepository $paymentRepository,
	)
	{
		date_default_timezone_set('Europe/Paris');
		
		$apartment = $contract->getApartment();
		
		$total = $apartment->getTotalAmount();
		
		$paymentType = $contract->getTypePayment();
		
		$payment = $paymentType->newPayment($total, $contract);
		
		$entityManager->persist($payment);
		$entityManager->flush();
		$payments = $paymentRepository->contractPayment($id);
		
		$data =  $this->json([
			'status' => 'success',
			'message' => 'Payment Effectuer',
			'elements' => [
				['id' => 'view-payment','view' => $this->render('controller/data-visualizer/payment/_card.html.twig', ['payments' => $payments])->getContent(),]
			]
		]);
		return $data;
	}
	
	#[Route('/contract/{id}/edit', name: 'app_contract_edit_get', methods: ['GET'])]
	public function getEdit(
		$id,
		Contract $contract,
		Request $request,
	): Response
	{
		$formContract = $this->createForm(ContractType::class, $contract, [
			'action' => "/contract/$id/edit",
		]);
		$formContract->handleRequest($request);
		return $this->render('controller/form/_contrat.html.twig', [
			'name_form' => 'update',
			'form_contract' => $formContract,
		]);
	}
	
	#[Route('/contract/{id]/edit', name: 'app_contract_edit_post', methods: ['POST'])]
	public function getPost(
		Contract               $contract,
		EntityManagerInterface $entityManager,
		Request                $request
	): JsonResponse
	{
		$formContract = $this->createForm(ContractType::class, $contract, [
			'action' => "/contract/{id}/edit",
		]);
		$formContract->handleRequest($request);
		if ($formContract->isSubmitted() && $formContract->isValid()) {
			$entityManager->flush();
			$data = $this->json([
				'status' => 'success',
				'message' => 'Updated',
				'elements' => [
					[
						'id' => 'contract-selected',
						'view' => $this->render('controller/data-visualizer/contract/_selected.html.twig', ['contact' => $contract])->getContent(),
					],
//					[
//						'id'=>'apartment-selected',
//						'view'=>$this->render('controller/data-visualizer/apartment/_selectedForOther.html.twig',['apartment'=>$apartment])->getContent(),
//					]
				],
			]);
		}
		return $data;
	}
	
	#[Route('/contract/{id}/receipt', name: 'app_contract_receipt_get', methods: ['GET'])]
	public function getReceiptGet(
		$id,
		Contract $contract,
		Request $request
	): Response
	{
		$formRecipt = $this->createForm(ReceiptType::class, $contract, [
			'action' => "/contract/$id/receipt",
		]);
		$formRecipt->handleRequest($request);
		return $this->render('controller/form/_receipt.html.twig', [
			'form_contract' => $formRecipt,
		]);
	}
}
