<?php

namespace App\DataFixtures;

use App\Entity\Contract;
use App\Repository\ApartmentRepository;
use App\Repository\TenantRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContractFixtures extends Fixture implements DependentFixtureInterface
{
	public function __construct(
		private ApartmentRepository $apartmentRepository,
		private TenantRepository $tenantRepository
	){}
	public function load(ObjectManager $manager): void
	{
		$faker = Factory::create('fr_FR');
		$apartments = $this->apartmentRepository->findAll();
		$tenants = $this->tenantRepository->findAll();
		$contracts = [];
		for($i=0;$i<mt_rand(1,50);$i++){
			$contract = new Contract();
			$contract
				->setStartAt($faker->dateTime())
				->setEndAt($faker->dateTime());
			$manager->persist($contract);
			$contracts[] = $contract;
		}
		
		foreach ($apartments as $apartment){
			$apartment
				->addContract(
					$contracts[mt_rand(0,count($contracts)-1)]
				);
		}
		
		foreach ($tenants as $tenant){
			$tenant
				->addContract(
					$contracts[mt_rand(0,count($contracts)-1)]
				);
		}
		$manager->flush();
	}
	
	public function getDependencies():array
	{
		return[
			ApartmentFixtures::class,
			TenantFixtures::class
		];
	}
}
