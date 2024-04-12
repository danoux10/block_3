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
		private OwnerRepository $ownerRepository,
		private InventoryRepository $inventoryRepository,
		private ContractRepository $contractRepository,
	){}
	public function load(ObjectManager $manager): void
	{
		$faker = Factory::create('fr_FR');
		$apartments = [];
		$owners = $this->ownerRepository->findAll();
		$inventories = $this->inventoryRepository->findAll();
		$contracts = $this->contractRepository->findAll();
		
		for ($i = 0; $i < 50; $i++) {
			$apartment = new Apartment();
			$apartment
				->setCode($faker->randomNumber(5, true))
				->setCity($faker->city())
				->setAddress($faker->streetAddress())
				->setCharge($faker->randomFloat(2, 50, 200))
				->setGuarantee($faker->randomFloat(2, 100, 500))
				->setRent($faker->randomFloat(2, 500, 2000));
			$apartments[] = $apartment;
			$manager->persist($apartment);
		}

		foreach ($owners as $owner){
			for($i=0;$i<mt_rand(1,3);$i++){
				$owner
					->addApartment(
						$apartments[mt_rand(0,count($apartments)-1)]
					);
			}
		}
		
		foreach ($inventories as $inventory) {
			$inventory
				->setApartment(
					$apartments[mt_rand(0, count($apartments) - 1)]
				);
		}
		
		foreach ($contracts as $contract){
			$contract
				->setApartment(
					$apartments[mt_rand(0,count($apartments)-1)]
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
