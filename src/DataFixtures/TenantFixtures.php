<?php

namespace App\DataFixtures;

use App\Entity\Tenant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TenantFixtures extends Fixture
{
	public function load(ObjectManager $manager): void
	{
		$faker = Factory::create('fr_FR');
		for($i=0;$i<mt_rand(1,50);$i++){
			$tenant = new Tenant();
			$tenant
				->setName($faker->firstName())
				->setLastname($faker->lastName())
				->setAdress($faker->address())
				->setEmail($faker->email())
				->setPhone($faker->phoneNumber())
				->setApl($faker->boolean());
			if($tenant->isApl()){
				$tenant->setAplValue($faker->bothify('????-####'));
			}
			$manager->persist($tenant);
		}
		
		$manager->flush();
	}
}
