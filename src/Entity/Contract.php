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

    #[ORM\ManyToMany(targetEntity: apartment::class, inversedBy: 'contracts')]
    private Collection $apartment;

    #[ORM\ManyToMany(targetEntity: tenant::class, inversedBy: 'contracts')]
    private Collection $tenant;

    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'contract')]
    private Collection $payments;

    #[ORM\OneToMany(targetEntity: Receipt::class, mappedBy: 'contract')]
    private Collection $receipts;

    public function __construct()
    {
        $this->apartment = new ArrayCollection();
        $this->tenant = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->receipts = new ArrayCollection();
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

    /**
     * @return Collection<int, apartment>
     */
    public function getApartment(): Collection
    {
        return $this->apartment;
    }

    public function addApartment(apartment $apartment): static
    {
        if (!$this->apartment->contains($apartment)) {
            $this->apartment->add($apartment);
        }

        return $this;
    }

    public function removeApartment(apartment $apartment): static
    {
        $this->apartment->removeElement($apartment);

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

    /**
     * @return Collection<int, Receipt>
     */
    public function getReceipts(): Collection
    {
        return $this->receipts;
    }

    public function addReceipt(Receipt $receipt): static
    {
        if (!$this->receipts->contains($receipt)) {
            $this->receipts->add($receipt);
            $receipt->setContract($this);
        }

        return $this;
    }

    public function removeReceipt(Receipt $receipt): static
    {
        if ($this->receipts->removeElement($receipt)) {
            // set the owning side to null (unless already changed)
            if ($receipt->getContract() === $this) {
                $receipt->setContract(null);
            }
        }

        return $this;
    }
}
