<?php

namespace App\Tests;

use App\Entity\Tenant;
use PHPUnit\Framework\TestCase;

class TenantTest extends TestCase
{
	public function testIsTrue(){
		$tenant = new Tenant();
		$tenant
			->setName('doe')
			->setLastName('john')
			->setAdress('7 rue des paquerette')
			->setEmail('john.doe@example.com')
			->setPhone('0615244425')
			->setAplValue('bc-44')
			->setApl('true');
		
		$this->assertTrue($tenant->getName()=='doe');
		$this->assertTrue($tenant->getLastname()=='john');
		$this->assertTrue($tenant->getAdress()=='7 rue des paquerette');
		$this->assertTrue($tenant->getEmail()=='john.doe@example.com');
		$this->assertTrue($tenant->getPhone()=='0615244425');
		$this->assertTrue($tenant->getAplValue()=='bc-44');
		$this->assertTrue($tenant->isApl()=='true');
	}
	public function testIsFalse(){
		$tenant = new Tenant();
		$tenant
			->setName('doe')
			->setLastName('john')
			->setAdress('7 rue des paquerette')
			->setEmail('john.doe@example.com')
			->setPhone('0615244425')
			->setAplValue('bc-44')
			->setApl('true');
		
		$this->assertFalse($tenant->getName()==='barbe');
		$this->assertFalse($tenant->getLastname()==='didier');
		$this->assertFalse($tenant->getAdress()==='7 rue des fleurs');
		$this->assertFalse($tenant->getEmail()==='didier.barbe@example.com');
		$this->assertFalse($tenant->getPhone()==='0620153541');
		$this->assertFalse($tenant->getAplValue()==='bd-55');
		$this->assertFalse($tenant->isApl()==='false');
	}
	public function testIsEmpty(){
		$tenant = new Tenant();
		$this->assertEmpty($tenant->getName());
		$this->assertEmpty($tenant->getLastname());
		$this->assertEmpty($tenant->getAdress());
		$this->assertEmpty($tenant->getEmail());
		$this->assertEmpty($tenant->getPhone());
		$this->assertEmpty($tenant->getAplValue());
		$this->assertEmpty($tenant->isApl());
	}
	
}
