<?php

namespace App\Tests;

use App\Entity\Apartment;
use PHPUnit\Framework\TestCase;

class ApartmentTest extends TestCase
{
	
    public function testIsTrue(){
	    $apartment = new Apartment();
			$apartment
				->setCode('10000')
				->setCity('Troyes')
				->setAdress('7 rue des coquelicos')
				->setCharge('102.50')
				->setGuarantee('150')
				->setRent('1200');
			
			$this->assertTrue($apartment->getCode()=='10000');
			$this->assertTrue($apartment->getCity()=='Troyes');
			$this->assertTrue($apartment->getAdress()=='7 rue des coquelicos');
			$this->assertTrue($apartment->getCharge()=='102.50');
			$this->assertTrue($apartment->getGuarantee()=='150');
			$this->assertTrue($apartment->getRent()=='1200');
    }
		
		public function testIsFalse(){
			$apartment = new Apartment();
			$apartment
				->setCode('1270')
				->setCity('lusigny sur barse')
				->setAdress('7 rue de la cruée')
				->setCharge('103.50')
				->setGuarantee('160')
				->setRent('1500');
			
			$this->assertFalse($apartment->getCode()==='10000');
			$this->assertFalse($apartment->getCity()==='Troyes');
			$this->assertFalse($apartment->getAdress()==='7 rue des coquelicos');
			$this->assertFalse($apartment->getCharge()==='102.50');
			$this->assertFalse($apartment->getGuarantee()==='150');
			$this->assertFalse($apartment->getRent()==='1200');
		}
		
		public function testIsEmpty(){
			$apartment = new Apartment();
			$this->assertEmpty($apartment->getCode());
			$this->assertEmpty($apartment->getCity());
			$this->assertEmpty($apartment->getAdress());
			$this->assertEmpty($apartment->getCharge());
			$this->assertEmpty($apartment->getGuarantee());
			$this->assertEmpty($apartment->getRent());
		}
}
