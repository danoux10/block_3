<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_at = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $end_at = null;
		

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    private ?Apartment $Apartment = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    private ?Tenant $Tenant = null;

    /**
     * @var Collection<int, Payment>
     */
    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'contract', orphanRemoval: true)]
    private Collection $payments;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
    }
		
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->start_at;
    }

    public function setStartAt(\DateTimeInterface $start_at): static
    {
        $this->start_at = $start_at;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->end_at;
    }

    public function setEndAt(\DateTimeInterface $end_at): static
    {
        $this->end_at = $end_at;

        return $this;
    }
		
    public function getApartment(): ?Apartment
    {
        return $this->Apartment;
    }

    public function setApartment(?Apartment $Apartment): static
    {
        $this->Apartment = $Apartment;

        return $this;
    }

    public function getTenant(): ?Tenant
    {
        return $this->Tenant;
    }

    public function setTenant(?Tenant $Tenant): static
    {
        $this->Tenant = $Tenant;

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setContract($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getContract() === $this) {
                $payment->setContract(null);
            }
        }

        return $this;
    }
}
