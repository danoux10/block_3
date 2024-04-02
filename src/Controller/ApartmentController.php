<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Form\ApartmentType;
use App\Repository\ApartmentRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApartmentController extends AbstractController
{
	#[Route('/', name: 'app_apartment', methods: ['GET', 'POST'])]
	public function index(ApartmentRepository $apartmentRepository, EntityManagerInterface $entityManager, Request $request,): Response
	{
		$data = $apartmentRepository->findAll();//Delete
//		$data = $apartmentRepository->ApartmentDesc();
		$tableHead = [
			'code postal',
			'ville',
			'adresse',
			'charge',
			'garantie',
			'loyer',
			'select'];
		$apartment = new Apartment();
		$formApartment = $this->createForm(ApartmentType::class,$apartment);
		$formApartment->handleRequest($request);
		if($formApartment->isSubmitted() && $formApartment->isValid()){
			$entityManager->persist($apartment);
			$entityManager->flush();
			return $this->redirectToRoute('app_apartment',[],Response::HTTP_SEE_OTHER);
		}
		return $this->render('apartment/index.html.twig', [
			'page_name' => 'Appartement',
			'type_form'=>'Ajouter',
			'heads'=>$tableHead,
			'data' => $data,
			'form_apartment' => $formApartment,
		]);
	}
	
	#[Route('/{id}/edit', name: 'app_apartment_selected', methods: ['GET', 'POST'])]
	public function view():Response
	{
		return $this->render('apartment/selected.html.twig',[
			'page_name'=>'Appartement',
		]);
	}
}
