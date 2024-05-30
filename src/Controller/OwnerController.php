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
	#[Route('/owner', name: 'app_owner', methods: ['GET'])]
	public function index(
		OwnerRepository        $OwnerRepository,
	): Response
	{
		$data = $OwnerRepository->OwnerDesc();
		return $this->render('owner/index.html.twig', [
			'page_name' => 'propriétaire',
			'type_form' => 'Ajouter',
			'data' => $data,
		]);
	}
	
	#[Route('/owner/add', name: 'app_owner_add_get', methods: ['GET'])]
	public function getAdd(
		Request $request
	): Response
	{
		$owner = new Owner();
		$owner_form = $this->createForm(OwnerType::class, $owner, [
			'action' => '/owner/add',
		]);
		$owner_form->handleRequest($request);
		return $this->render('controller/form/_owner.html.twig', [
			'form_name' => 'Ajouter',
			'form_owner' => $owner_form,
		]);
	}
	
	#[Route('/owner/add', name: 'app_owner_add_post', methods: ['POST'])]
	public function postAdd(
		EntityManagerInterface $entityManager,
		OwnerRepository        $OwnerRepository,
		Request $request
	)
	{
		$owner = new Owner();
		$owner_form = $this->createForm(OwnerType::class, $owner, [
			'action' => '/owner/add',
		]);
		$owner_form->handleRequest($request);
		if ($owner_form->isSubmitted() && $owner_form->isValid()) {
			$entityManager->persist($owner);
			$entityManager->flush();
			$owners = $OwnerRepository->OwnerDesc();
			$data = $this->json([
				'status' => 'success',
				'message' => 'Propriétaire ajouter avec success',
				'elements' => [
					[
						'id' => 'owner-table',
						'view' => $this->render('controller/data-visualizer/owner/_table.html.twig',['data'=>$owners])->getContent(),
					],
				],
			]);
		}
		return $data;
	}
	
	#[Route('/owner/{id}', name: 'app_owner_selected', methods: ['GET'])]
	public function view(
		$id,
		Owner $owner,
		ApartmentRepository $ApartmentRepository,
	): Response
	{
		$apartments = $ApartmentRepository->OwnerApartment($id);
		return $this->render('owner/selected.html.twig', [
			'page_name' => 'propriétaire',
			'owner' => $owner,
			'apartments' => $apartments,
		]);
	}
	
	#[Route('/owner/{id}/edit', name: 'app_owner_edit_get', methods: ['GET'])]
	public function getEdit(
		$id,
		Owner $owner,
		Request $request
	): Response
	{
		$owner_form = $this->createForm(OwnerType::class, $owner, [
			'action' => "/owner/$id/edit",
		]);
		$owner_form->handleRequest($request);
		return $this->render('controller/form/_owner.html.twig', [
			'form_name' => 'Mettre à jour',
			'form_owner' => $owner_form,
		]);
	}
	
	#[Route('/owner/{id}/edit', name: 'app_owner_edit_post', methods: ['POST'])]
	public function postEdit(
		Owner                  $owner,
		EntityManagerInterface $entityManager,
		Request                $request
	): JsonResponse
	{
		$owner_form = $this->createForm(OwnerType::class, $owner, [
			'action' => '/owner/{id}/edit',
		]);
		$owner_form->handleRequest($request);
		if ($owner_form->isSubmitted() && $owner_form->isValid()) {
			$entityManager->flush();
			$data = $this->json([
				'status' => 'success',
				'message' => 'Mis a jours ok',
				'elements' => [
					[
						'id' => 'owner-selected',
						'view' => $this->render('controller/data-visualizer/owner/_selected.html.twig', ['owner' => $owner])->getContent(),
					],
				],
			]);
		}
		return $data;
	}
}
