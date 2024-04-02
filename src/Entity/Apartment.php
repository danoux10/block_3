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
    private ?string $adress = null;

    #[ORM\Column(length: 255)]
    private ?string $guarantee = null;

    #[ORM\Column(length: 255)]
    private ?string $charge = null;

    #[ORM\Column(length: 255)]
    private ?string $rent = null;

    #[ORM\OneToMany(targetEntity: Inventory::class, mappedBy: 'apartment')]
    private Collection $inventories;

    #[ORM\ManyToMany(targetEntity: Contract::class, mappedBy: 'apartment')]
    private Collection $contracts;

    #[ORM\ManyToMany(targetEntity: tenant::class, inversedBy: 'apartments')]
    private Collection $tenant;

    #[ORM\ManyToMany(targetEntity: owner::class, inversedBy: 'apartments')]
    private Collection $owner;

    public function __construct()
    {
        $this->inventories = new ArrayCollection();
        $this->contracts = new ArrayCollection();
        $this->tenant = new ArrayCollection();
        $this->owner = new ArrayCollection();
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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getGuarantee(): ?string
    {
        return $this->guarantee;
    }

    public function setGuarantee(string $guarantee): static
    {
        $this->guarantee = $guarantee;

        return $this;
    }

    public function getCharge(): ?string
    {
        return $this->charge;
    }

    public function setCharge(string $charge): static
    {
        $this->charge = $charge;

        return $this;
    }

    public function getRent(): ?string
    {
        return $this->rent;
    }

    public function setRent(string $rent): static
    {
        $this->rent = $rent;

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
            $contract->addApartment($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): static
    {
        if ($this->contracts->removeElement($contract)) {
            $contract->removeApartment($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, tenant>
     */
    public function getTenant(): Collection
    {
        return $this->tenant;
    }

    public function addTenant(tenant $tenant): static
    {
        if (!$this->tenant->contains($tenant)) {
            $this->tenant->add($tenant);
        }

        return $this;
    }

    public function removeTenant(tenant $tenant): static
    {
        $this->tenant->removeElement($tenant);

        return $this;
    }

    /**
     * @return Collection<int, owner>
     */
    public function getOwner(): Collection
    {
        return $this->owner;
    }

    public function addOwner(owner $owner): static
    {
        if (!$this->owner->contains($owner)) {
            $this->owner->add($owner);
        }

        return $this;
    }

    public function removeOwner(owner $owner): static
    {
        $this->owner->removeElement($owner);

        return $this;
    }
}
