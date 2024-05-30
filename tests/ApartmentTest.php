<?php

namespace App\Tests;

use App\Entity\Apartment;
use PHPUnit\Framework\TestCase;

class ApartmentTest extends TestCase
{
	
    public function testIsTrue(){
	    $Apartment = new Apartment();
			$Apartment
				->setCode('10000')
				->setCity('Troyes')
				->setAddress('7 rue des coquelicos')
				->setCharge('102.50')
				->setGuarantee('150')
				->setRent('1200');
			
			$this->assertTrue($Apartment->getCode()=='10000');
			$this->assertTrue($Apartment->getCity()=='Troyes');
			$this->assertTrue($Apartment->getAddress()=='7 rue des coquelicos');
			$this->assertTrue($Apartment->getCharge()=='102.50');
			$this->assertTrue($Apartment->getGuarantee()=='150');
			$this->assertTrue($Apartment->getRent()=='1200');
    }
		
		public function testIsFalse(){
			$Apartment = new Apartment();
			$Apartment
				->setCode('1270')
				->setCity('lusigny sur barse')
				->setAddress('7 rue de la cruée')
				->setCharge('103.50')
				->setGuarantee('160')
				->setRent('1500');
			
			$this->assertFalse($Apartment->getCode()==='10000');
			$this->assertFalse($Apartment->getCity()==='Troyes');
			$this->assertFalse($Apartment->getAddress()==='7 rue des coquelicos');
			$this->assertFalse($Apartment->getCharge()==='102.50');
			$this->assertFalse($Apartment->getGuarantee()==='150');
			$this->assertFalse($Apartment->getRent()==='1200');
		}
		
		public function testIsEmpt*y(){
			$Apartment = new Apartment();
			$this->assertEmpty($Apartment->getCode());
			$this->assertEmpty($Apartment->getCity());
			$this->assertEmpty($Apartment->getAddress());
			$this->assertEmpty($Apartment->getCharge());
			$this->assertEmpty($Apartment->getGuarantee());
			$this->assertEmpty($Apartment->getRent());
		}
}
