<?php

namespace App\Tests;

use App\Entity\Owner;
use PHPUnit\Framework\TestCase;

class OwnerTest extends TestCase
{
	public function testIsTrue(){
		$Owner = new Owner();
		$Owner
			->setName('doe')
			->setLastName('john')
			->setAddress('7 rue des paquerette')
			->setEmail('john.doe@example.com')
			->setPhone('0615244425');
		
		$this->assertTrue($Owner->getName()=='doe');
		$this->assertTrue($Owner->getLastname()=='john');
		$this->assertTrue($Owner->getAddress()=='7 rue des paquerette');
		$this->assertTrue($Owner->getEmail()=='john.doe@example.com');
		$this->assertTrue($Owner->getPhone()=='0615244425');
	}
	public function testIsFalse(){
		$Owner = new Owner();
		$Owner
			->setName('doe')
			->setLastName('john')
			->setAddress('7 rue des paquerette')
			->setEmail('john.doe@example.com')
			->setPhone('0615244425');
		
		$this->assertFalse($Owner->getName()==='barbe');
		$this->assertFalse($Owner->getLastname()==='didier');
		$this->assertFalse($Owner->getAddress()==='7 rue des tulipe');
		$this->assertFalse($Owner->getEmail()==='didier.barbe@example.com');
		$this->assertFalse($Owner->getPhone()==='0615121415');
	}
	public function testIsEmpty(){
		$Owner = new Owner();
		$this->assertEmpty($Owner->getName());
		$this->assertEmpty($Owner->getLastname());
		$this->assertEmpty($Owner->getAddress());
		$this->assertEmpty($Owner->getEmail());
		$this->assertEmpty($Owner->getPhone());
	}
	
}
