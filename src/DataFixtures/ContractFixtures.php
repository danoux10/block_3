<?php

namespace App\DataFixtures;

use App\Entity\Contract;
use App\Repository\PaymentTypeRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContractFixtures extends Fixture
{
	public function load(ObjectManager $manager): void
	{
		$faker = Factory::create('fr_FR');
		for ($i = 0; $i < mt_rand(1, 50); $i++) {
			$contract = new Contract();
			$contract
				->setStartAt($faker->dateTime())
				->setEndAt($faker->dateTime());
			$manager->persist($contract);
		}
		$manager->flush();
	}
}
