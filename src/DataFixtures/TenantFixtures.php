<?php

namespace App\DataFixtures;

use App\Entity\Tenant;
use App\Repository\ContractRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TenantFixtures extends Fixture
{
	public function __construct(
		private ContractRepository $contractRepository,
	)
	{
	}
	
	public function load(ObjectManager $manager): void
	{
		$faker = Factory::create('fr_FR');
		$Tenants = [];
		$contracts = $this->contractRepository->findAll();
		for ($i = 0; $i < 15; $i++) {
			$Tenant = new Tenant();
			$Tenant
				->setName($faker->firstName())
				->setLastname($faker->lastName())
				->setAddress($faker->address())
				->setEmail($faker->email())
				->setPhone($faker->phoneNumber())
				->setApl($faker->boolean());
			if ($Tenant->isApl()) {
				$Tenant->setAplValue($faker->bothify('????-####'));
			}
			$Tenants[]=$Tenant;
			$manager->persist($Tenant);
		}
		
		foreach ($contracts as $contract){
			$contract
				->setTenant(
					$Tenants[mt_rand(0,count($Tenants)-1)]
				);
		}
		
		$manager->flush();
	}
	
	public function getDependencies(): array
	{
		return [
			ContractFixtures::class
		];
	}
}