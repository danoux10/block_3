<?php

namespace App\Tests;

use App\Entity\Tenant;
use PHPUnit\Framework\TestCase;

class TenantTest extends TestCase
{
	public function testIsTrue(){
		$Tenant = new Tenant();
		$Tenant
			->setName('doe')
			->setLastName('john')
			->setAddress('7 rue des paquerette')
			->setEmail('john.doe@example.com')
			->setPhone('0615244425')
			->setAplValue('bc-44')
			->setApl('true');
		
		$this->assertTrue($Tenant->getName()=='doe');
		$this->assertTrue($Tenant->getLastname()=='john');
		$this->assertTrue($Tenant->getAddress()=='7 rue des paquerette');
		$this->assertTrue($Tenant->getEmail()=='john.doe@example.com');
		$this->assertTrue($Tenant->getPhone()=='0615244425');
		$this->assertTrue($Tenant->getAplValue()=='bc-44');
		$this->assertTrue($Tenant->isApl()=='true');
	}
	public function testIsFalse(){
		$Tenant = new Tenant();
		$Tenant
			->setName('doe')
			->setLastName('john')
			->setAddress('7 rue des paquerette')
			->setEmail('john.doe@example.com')
			->setPhone('0615244425')
			->setAplValue('bc-44')
			->setApl('true');
		
		$this->assertFalse($Tenant->getName()==='barbe');
		$this->assertFalse($Tenant->getLastname()==='didier');
		$this->assertFalse($Tenant->getAddress()==='7 rue des fleurs');
		$this->assertFalse($Tenant->getEmail()==='didier.barbe@example.com');
		$this->assertFalse($Tenant->getPhone()==='0620153541');
		$this->assertFalse($Tenant->getAplValue()==='bd-55');
		$this->assertFalse($Tenant->isApl()==='false');
	}
	public function testIsEmpty(){
		$Tenant = new Tenant();
		$this->assertEmpty($Tenant->getName());
		$this->assertEmpty($Tenant->getLastname());
		$this->assertEmpty($Tenant->getAddress());
		$this->assertEmpty($Tenant->getEmail());
		$this->assertEmpty($Tenant->getPhone());
		$this->assertEmpty($Tenant->getAplValue());
		$this->assertEmpty($Tenant->isApl());
	}
	
}
