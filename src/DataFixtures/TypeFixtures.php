<?php

namespace App\DataFixtures;

use App\Entity\PaymentType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TypeFixtures extends Fixture
{
	public function load(ObjectManager $manager): void
	{
		$faker = Factory::create('fr_FR');
		for ($i = 0; $i < 2; $i++) {
			$type = new PaymentType();
			$type
				->setName($faker->randomLetter());
			$manager->persist($type);
		}
		$manager->flush();
	}
}
