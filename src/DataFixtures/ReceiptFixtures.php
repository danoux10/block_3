<?php

namespace App\DataFixtures;

use App\Entity\Receipt;
use App\Repository\ContractRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReceiptFixtures extends Fixture implements DependentFixtureInterface
{
	public function __construct(private ContractRepository $contractRepository)
	{
	}
	public function load(ObjectManager $manager): void
	{
		$faker = Factory::create('fr_FR');
		$contracts = $this->contractRepository->findAll();
		$receipts = [];
		for($i=0;$i<mt_rand(1,25);$i++){
			$receipt = new Receipt();
			$receipt
				->setStartAt($faker->dateTime())
				->setEndAt($faker->dateTime());
			$manager->persist($receipt);
			$receipts[] = $receipt;
		}
		foreach ($contracts as $contract) {
			$contract
				->addReceipt(
					$receipts[mt_rand(0, count($receipts) - 1)]
				);
		}
		
		$manager->flush();
	}
	public function getDependencies(): array
	{
		return [ContractFixtures::class];
	}
}
