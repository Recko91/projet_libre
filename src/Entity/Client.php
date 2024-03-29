<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @UniqueEntity(
 *  fields= {"email"},
 *  message= "This email is already used"
 * )
 */
class Client implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $businessName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="You must type the same password")
     */
    public $password_validation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * 
     */
    private $reservations;

    /**
     * 
     */
    private $clientAddresses;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->clientAddresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBusinessName(): ?string
    {
        return $this->businessName;
    }

    public function setBusinessName(string $businessName): self
    {
        $this->businessName = $businessName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setClientId($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getClientId() === $this) {
                $reservation->setClientId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ClientAddress[]
     */
    public function getClientAddresses(): Collection
    {
        return $this->clientAddresses;
    }

    public function addClientAddress(ClientAddress $clientAddress): self
    {
        if (!$this->clientAddresses->contains($clientAddress)) {
            $this->clientAddresses[] = $clientAddress;
            $clientAddress->setClientId($this);
        }

        return $this;
    }

    public function removeClientAddress(ClientAddress $clientAddress): self
    {
        if ($this->clientAddresses->removeElement($clientAddress)) {
            // set the owning side to null (unless already changed)
            if ($clientAddress->getClientId() === $this) {
                $clientAddress->setClientId(null);
            }
        }

        return $this;
    }

    public function eraseCredentials() {}

    public function getUsername(): ?string {
        return $this->email;
    }

    public function getSalt() {}

    public function getRoles() {
        return ['ROLE_CLIENT'];
    }
}
