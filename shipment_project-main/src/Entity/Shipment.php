<?php

namespace App\Entity;

use App\Repository\ShipmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShipmentRepository::class)]
class Shipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fullName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?int $phone = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cargoInfo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $destinationCountry = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cargoCode = null;

    #[ORM\Column]
    private ?bool $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCargoInfo(): ?string
    {
        return $this->cargoInfo;
    }

    public function setCargoInfo(?string $cargoInfo): static
    {
        $this->cargoInfo = $cargoInfo;

        return $this;
    }

    public function getDestinationCountry(): ?string
    {
        return $this->destinationCountry;
    }

    public function setDestinationCountry(?string $destinationCountry): static
    {
        $this->destinationCountry = $destinationCountry;

        return $this;
    }

    public function getCargoCode(): ?string
    {
        return $this->cargoCode;
    }

    public function setCargoCode(?string $cargoCode): static
    {
        $this->cargoCode = $cargoCode;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }
}
