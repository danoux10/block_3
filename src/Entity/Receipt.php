<?php

namespace App\Entity;

use App\Repository\ReceiptRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReceiptRepository::class)]
class Receipt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_at = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $end_at = null;

    #[ORM\Column]
    private ?float $charge = null;

    #[ORM\Column]
    private ?float $water = null;

    #[ORM\Column]
    private ?float $electricity = null;

    #[ORM\Column]
    private ?float $gas = null;

    #[ORM\ManyToOne(inversedBy: 'receipts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?contract $contract = null;

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

    public function getCharge(): ?float
    {
        return $this->charge;
    }

    public function setCharge(float $charge): static
    {
        $this->charge = $charge;

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

    public function getContract(): ?contract
    {
        return $this->contract;
    }

    public function setContract(?contract $contract): static
    {
        $this->contract = $contract;

        return $this;
    }
}
