<?php

namespace App\DataFixtures;

use App\Entity\Inventory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class InventoryFixtures extends Fixture
{
	public function load(ObjectManager $manager): void
	{
		$faker = Factory::create('fr_FR');
		for ($i = 0; $i < 50; $i++) {
			$inventory = new Inventory();
			$inventory
				->setCreatedAt($faker->dateTime())
				->setRemark($faker->paragraph);
			$manager->persist($inventory);
		}
		$manager->flush();
	}
}