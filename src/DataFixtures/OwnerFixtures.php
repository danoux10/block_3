<?php

namespace App\DataFixtures;

use App\Entity\Owner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OwnerFixtures extends Fixture
{
	public function load(ObjectManager $manager): void
	{
		$faker = Factory::create('fr_FR');
		for($i=0;$i<25;$i++){
			$Owner = new Owner();
			$Owner
				->setName($faker->firstName())
				->setLastname($faker->lastName())
				->setEmail($faker->email())
				->setAddress($faker->Address())
				->setPhone($faker->phoneNumber());
			$manager->persist($Owner);
		}
		$manager->flush();
	}
}
