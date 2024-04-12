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
		$tenants = [];
		$contracts = $this->contractRepository->findAll();
		for ($i = 0; $i < 15; $i++) {
			$tenant = new Tenant();
			$tenant
				->setName($faker->firstName())
				->setLastname($faker->lastName())
				->setAddress($faker->address())
				->setEmail($faker->email())
				->setPhone($faker->phoneNumber())
				->setApl($faker->boolean());
			if ($tenant->isApl()) {
				$tenant->setAplValue($faker->bothify('????-####'));
			}
			$tenants[]=$tenant;
			$manager->persist($tenant);
		}
		
		foreach ($contracts as $contract){
			$contract
				->setTenant(
					$tenants[mt_rand(0,count($tenants)-1)]
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