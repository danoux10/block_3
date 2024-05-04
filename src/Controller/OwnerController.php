<?php

namespace App\Controller;

use App\Entity\Owner;
use App\Form\OwnerType;
use App\Form\OwnerApartType;
use App\Repository\ApartmentRepository;
use App\Repository\OwnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OwnerController extends AbstractController
{
	#[Route('/owner', name: 'app_owner', methods: ['GET', 'POST'])]
	public function index(
		OwnerRepository        $OwnerRepository,
		EntityManagerInterface $entityManager,
		Request                $request
	): Response
	{
		$data = $OwnerRepository->findAll();//delete
//		$data = $OwnerRepository->OwnerDesc();
		$tableHead = [
			'nom',
			'prénom',
			'email',
			'téléphone',
			'adresse',
			'select'
		];
		$Owner = new Owner();
		$formOwner = $this->createForm(OwnerType::class, $Owner);
		$formOwner->handleRequest($request);
		if ($formOwner->isSubmitted() && $formOwner->isValid()) {
			$entityManager->persist($Owner);
			$entityManager->flush();
			return $this->redirectToRoute('app_owner', [], Response::HTTP_SEE_OTHER);
		}
		return $this->render('owner/index.html.twig', [
			'page_name' => 'propriétaire',
			'type_form' => 'Ajouter',
			'heads' => $tableHead,
			'data' => $data,
			'form_owner' => $formOwner,
		]);
	}
	
	#[Route('/owner/{id}', name: 'app_owner_selected', methods: ['GET'])]
	public function view(
		$id,
		Owner $owner,
		ApartmentRepository $ApartmentRepository,
		EntityManagerInterface $entityManager,
		Request $request
	): Response
	{
		//get data
		$apartments = $ApartmentRepository->OwnerApartment($id);
		//form
//		$apartment_form = $this->createForm(ownerApartType::class,$owner);
//		$apartment_form->handleRequest($request);
//		if ($apartment_form->isSubmitted() && $apartment_form->isValid()) {
//			$entityManager->persist($owner);
//			$entityManager->flush();
//			return $this->redirectToRoute('app_owner_selected', ['id' => $id], Response::HTTP_SEE_OTHER);
//		}
		return $this->render('owner/selected.html.twig', [
			'page_name' => 'propriétaire',
//			'form_apart'=>$apartment_form,
			'owner' => $owner,
			'apartments' => $apartments,
		]);
	}
	
	#[Route('/owner/{id}/edit', name: 'app_owner_get', methods: ['GET'])]
	public function getEdit(
		$id,
		Owner $owner,
		Request $request
	): Response
	{
		$owner_form = $this->createForm(OwnerType::class, $owner,[
			'action'=>"/owner/$id/edit",
		]);
		$owner_form->handleRequest($request);
		return $this->render('controller/form/owner.html.twig', [
			'form_owner' => $owner_form,
		]);
	}
	#[Route('/owner/{id}/edit', name: 'app_owner_post', methods: ['POST'])]
	public function postEdit(
		$id,
		Owner $owner,
		EntityManagerInterface $entityManager,
		Request $request
	): JsonResponse
	{
		$owner_form = $this->createForm(OwnerType::class, $owner,[
			'action'=>'/owner/{id}/edit',
		]);
		$owner_form->handleRequest($request);
		if ($owner_form->isSubmitted() && $owner_form->isValid()) {
			$entityManager->flush();
//			return $this->redirectToRoute('app_owner_selected', ['id' => $id], Response::HTTP_SEE_OTHER);
			return $this->json([
				'status' =>'success',
				'message' => 'Mis a jours ok',
				'elements'=>[
					[
						'id'=>'owner-selected',
						'view'=>$this->render('owner/data_visualizer/_selected.html.twig',['owner'=>$owner])->getContent(),
					],
				],
			]);
		}
		
	}
}
