<?php

namespace App\Tests;

use App\Entity\Owner;
use PHPUnit\Framework\TestCase;

class OwnerTest extends TestCase
{
	public function testIsTrue(){
		$owner = new Owner();
		$owner
			->setName('doe')
			->setLastName('john')
			->setAdress('7 rue des paquerette')
			->setEmail('john.doe@example.com')
			->setPhone('0615244425');
		
		$this->assertTrue($owner->getName()=='doe');
		$this->assertTrue($owner->getLastname()=='john');
		$this->assertTrue($owner->getAdress()=='7 rue des paquerette');
		$this->assertTrue($owner->getEmail()=='john.doe@example.com');
		$this->assertTrue($owner->getPhone()=='0615244425');
	}
	public function testIsFalse(){
		$owner = new Owner();
		$owner
			->setName('doe')
			->setLastName('john')
			->setAdress('7 rue des paquerette')
			->setEmail('john.doe@example.com')
			->setPhone('0615244425');
		
		$this->assertFalse($owner->getName()==='barbe');
		$this->assertFalse($owner->getLastname()==='didier');
		$this->assertFalse($owner->getAdress()==='7 rue des tulipe');
		$this->assertFalse($owner->getEmail()==='didier.barbe@example.com');
		$this->assertFalse($owner->getPhone()==='0615121415');
	}
	public function testIsEmpty(){
		$owner = new Owner();
		$this->assertEmpty($owner->getName());
		$this->assertEmpty($owner->getLastname());
		$this->assertEmpty($owner->getAdress());
		$this->assertEmpty($owner->getEmail());
		$this->assertEmpty($owner->getPhone());
	}
	
}
