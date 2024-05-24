<?php

namespace App\Entity;

use App\Repository\ApartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApartmentRepository::class)]
class Apartment
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;
	
	#[ORM\Column(length: 255)]
	private ?string $code = null;
	
	#[ORM\Column(length: 255)]
	private ?string $city = null;
	
	#[ORM\Column(length: 255)]
	private ?string $address = null;
	
	#[ORM\Column]
	private ?float $charge = null;
	
	#[ORM\Column]
	private ?float $guarantee = null;
	
	#[ORM\Column]
	private ?float $rent = null;
	
	/**
	 * @var Collection<int, Owner>
	 */
	#[ORM\ManyToMany(targetEntity: Owner::class, inversedBy: 'Apartments', orphanRemoval: true)]
	private Collection $Owner;
	
	/**
	 * @var Collection<int, Inventory>
	 */
	#[ORM\OneToMany(targetEntity: Inventory::class, mappedBy: 'Apartment', orphanRemoval: true)]
	private Collection $inventories;
	
	/**
	 * @var Collection<int, Contract>
	 */
	#[ORM\OneToMany(targetEntity: Contract::class, mappedBy: 'Apartment', orphanRemoval: true)]
	private Collection $contracts;
	
	#[ORM\Column]
	private ?float $water = null;
	
	#[ORM\Column]
	private ?float $electricity = null;
	
	#[ORM\Column]
	private ?float $gas = null;
	
	public function __construct()
	{
		$this->Owner = new ArrayCollection();
		$this->inventories = new ArrayCollection();
		$this->contracts = new ArrayCollection();
	}
	
	public function getId(): ?int
	{
		return $this->id;
	}
	
	public function getCode(): ?string
	{
		return $this->code;
	}
	
	public function setCode(string $code): static
	{
		$this->code = $code;
		
		return $this;
	}
	
	public function getCity(): ?string
	{
		return $this->city;
	}
	
	public function setCity(string $city): static
	{
		$this->city = $city;
		
		return $this;
	}
	
	public function getAddress(): ?string
	{
		return $this->address;
	}
	
	public function setAddress(string $address): static
	{
		$this->address = $address;
		
		return $this;
	}
	
	public function getWater(): ?float
	{
		return $this->water;
	}
	
	public function setWater(float $water): static
	{
		$this->water = $water;
		
		return $this;
	}
	
	public function getElectricity(): ?float
	{
		return $this->electricity;
	}
	
	public function setElectricity(float $electricity): static
	{
		$this->electricity = $electricity;
		
		return $this;
	}
	
	public function getGas(): ?float
	{
		return $this->gas;
	}
	
	public function setGas(float $gas): static
	{
		$this->gas = $gas;
		
		return $this;
	}
	
	public function getCharge(): ?float
	{
		return $this->charge;
	}
	
	public function setCharge(float $charge): static
	{
		$this->charge = $charge;
		
		return $this;
	}
	
	public function getGuarantee(): ?float
	{
		return $this->guarantee;
	}
	
	public function setGuarantee(float $guarantee): static
	{
		$this->guarantee = $guarantee;
		
		return $this;
	}
	
	public function getRent(): ?float
	{
		return $this->rent;
	}
	
	public function setRent(float $rent): static
	{
		$this->rent = $rent;
		
		return $this;
	}
	
	/**
	 * @return Collection<int, Owner>
	 */
	public function getOwner(): Collection
	{
		return $this->Owner;
	}
	
	public function addOwner(Owner $Owner): static
	{
		if (!$this->Owner->contains($Owner)) {
			$this->Owner->add($Owner);
		}
		
		return $this;
	}
	
	public function removeOwner(Owner $Owner): static
	{
		$this->Owner->removeElement($Owner);
		
		return $this;
	}
	
	/**
	 * @return Collection<int, Inventory>
	 */
	public function getInventories(): Collection
	{
		return $this->inventories;
	}
	
	public function addInventory(Inventory $inventory): static
	{
		if (!$this->inventories->contains($inventory)) {
			$this->inventories->add($inventory);
			$inventory->setApartment($this);
		}
		
		return $this;
	}
	
	public function removeInventory(Inventory $inventory): static
	{
		if ($this->inventories->removeElement($inventory)) {
			// set the owning side to null (unless already changed)
			if ($inventory->getApartment() === $this) {
				$inventory->setApartment(null);
			}
		}
		
		return $this;
	}
	
	/**
	 * @return Collection<int, Contract>
	 */
	public function getContracts(): Collection
	{
		return $this->contracts;
	}
	
	public function addContract(Contract $contract): static
	{
		if (!$this->contracts->contains($contract)) {
			$this->contracts->add($contract);
			$contract->setApartment($this);
		}
		
		return $this;
	}
	
	public function removeContract(Contract $contract): static
	{
		if ($this->contracts->removeElement($contract)) {
			// set the owning side to null (unless already changed)
			if ($contract->getApartment() === $this) {
				$contract->setApartment(null);
			}
		}
		
		return $this;
	}
	
	public function calculateTotalCharge()
	{
		$total = $this->getWater() + $this->getElectricity() + $this->getGas();
		$this->setCharge($total);
	}
	
	function getTotalAmount(){
		$total = ($this->getCharge()+$this->getRent())+0.08;
		return $total;
	}
}
