<?php

namespace App\DataFixtures;

use App\Entity\Apartment;
use App\Repository\ContractRepository;
use App\Repository\InventoryRepository;
use App\Repository\OwnerRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ApartmentFixtures extends Fixture implements DependentFixtureInterface
{
	public function __construct(
		private OwnerRepository $OwnerRepository,
		private InventoryRepository $inventoryRepository,
		private ContractRepository $contractRepository,
	){}
	public function load(ObjectManager $manager): void
	{
		$faker = Factory::create('fr_FR');
		$Apartments = [];
		$Owners = $this->OwnerRepository->findAll();
		$inventories = $this->inventoryRepository->findAll();
		$contracts = $this->contractRepository->findAll();
		
		for ($i = 0; $i < 50; $i++) {
			$Apartment = new Apartment();
			$Apartment
				->setCode($faker->randomNumber(5, true))
				->setCity($faker->city())
				->setAddress($faker->streetAddress())
				->setCharge($faker->randomFloat(2, 50, 200))
				->setGuarantee($faker->randomFloat(2, 100, 500))
				->setRent($faker->randomFloat(2, 500, 2000));
			$Apartments[] = $Apartment;
			$manager->persist($Apartment);
		}

		foreach ($Owners as $Owner){
			for($i=0;$i<mt_rand(1,3);$i++){
				$Owner
					->addApartment(
						$Apartments[mt_rand(0,count($Apartments)-1)]
					);
			}
		}
		
		foreach ($inventories as $inventory) {
			$inventory
				->setApartment(
					$Apartments[mt_rand(0, count($Apartments) - 1)]
				);
		}
		
		foreach ($contracts as $contract){
			$contract
				->setApartment(
					$Apartments[mt_rand(0,count($Apartments)-1)]
				);
		}
		
		$manager->flush();
	}

	public function getDependencies():array
	{
		return [
			OwnerFixtures::class,
			InventoryFixtures::class,
			ContractFixtures::class,
		];
	}
}
