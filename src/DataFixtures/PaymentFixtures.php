<?php

namespace App\DataFixtures;

use App\Entity\Payment;
use App\Repository\ContractRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PaymentFixtures extends Fixture implements DependentFixtureInterface
{
	public function __construct(private ContractRepository $contractRepository)
	{
	}
	
	public function load(ObjectManager $manager): void
	{
		$faker = Factory::create('fr_FR');
		$contracts = $this->contractRepository->findAll();
		$payments = [];
		
		for ($i = 0; $i < mt_rand(1, 50); $i++) {
			$payment = new Payment();
			$payment
				->setCreatedAt($faker->dateTime())
				->setSum($faker->randomFloat(2, 500, 2000));
			$manager->persist($payment);
			$payments[] = $payment;
		}
		
		foreach ($contracts as $contract) {
			$contract
				->addPayment(
					$payments[mt_rand(0, count($payments) - 1)]
				);
		}
		
		$manager->flush();
	}
	
	public function getDependencies(): array
	{
		return [ContractFixtures::class];
	}
}
