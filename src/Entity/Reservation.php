<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $userId;


    /**
     * @ORM\Column(type="integer")
     */
    private $addressId;

    /**
     * @ORM\Column(type="integer")
     */
    private $vehicleQuantity;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId($userId): self
    {
        $this->userId = $userId;

        return $this;
    }


    public function getAddressId(): ?int
    {
        return $this->addressId;
    }

    public function setAddressId($addressId): self
    {
        $this->addressId = $addressId;

        return $this;
    }

    public function getVehicleQuantity(): ?int
    {
        return $this->vehicleQuantity;
    }

    public function setVehicleQuantity(int $vehicleQuantity): self
    {
        $this->vehicleQuantity = $vehicleQuantity;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }
}
