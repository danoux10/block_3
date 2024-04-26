<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Form\ContractType;
use App\Repository\ApartmentRepository;
use App\Repository\ContractRepository;
use App\Repository\PaymentRepository;
use App\Repository\ReceiptRepository;
use App\Repository\TenantRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContractController extends AbstractController
{
	#[Route('/contract', name: 'app_contract', methods: ['GET', 'POST'])]
	public function index(
		ContractRepository     $contractRepository,
		EntityManagerInterface $entityManager,
		Request                $request,
	): Response
	{
//		$data = $contractRepository->findAll();//delete
//		$data = $contractRepository->ContractDesc();
		$data = $contractRepository->findAllJoin();
		$tableHead = [
			'début',
			'fin',
			'Appartement ville',
			'Appartement Adresse',
			'Locataire Email',
			'select'
		];
		$contract = new Contract();
		$formContract = $this->createForm(ContractType::class, $contract);
		$formContract->handleRequest($request);
		if ($formContract->isSubmitted() && $formContract->isValid()) {
			$entityManager->persist($contract);
			$entityManager->flush();
			return $this->redirectToRoute('app_contract', [], Response::HTTP_SEE_OTHER);
		}
	
		return $this->render('contract/index.html.twig', [
			'page_name' => 'contract',
			'type_form' =>'Ajouter',
			'form_method' => 'add',
			'heads'=>$tableHead,
			'data'=>$data,
			'form_contract'=>$formContract,
//			dd($data)
		]);
	}
	#[Route('/contract/{id}/edit', name: 'app_contract_selected',methods:['GET','POST'])]
	public function view(
		$id,
		Contract $contract,
		PaymentRepository $paymentRepository,
//		ReceiptRepository $receiptRepository,
//		ApartmentRepository $ApartmentRepository,
		EntityManagerInterface $entityManager,
		Request                $request,
	):Response{
//		$Apartment = $ApartmentRepository->ContractApartment($id);
		$payments = $paymentRepository->ContractPayment($id);
//		$receipts = $receiptRepository->ContractReceipt($id);
		$formContract = $this->createForm(ContractType::class, $contract);
		$formContract->handleRequest($request);
		if ($formContract->isSubmitted() && $formContract->isValid()) {
			$entityManager->flush();
			return $this->redirectToRoute('app_contract', [], Response::HTTP_SEE_OTHER);
		}
		return $this->render('contract/selected.html.twig',[
			'page_name'=>'contract',
			'contract'=>$contract,
			'payments'=>$payments,
			
			'type_form' =>'Update',
			'form_method' => 'update',
			'form_contract'=>$formContract,
		]);
	}
}
