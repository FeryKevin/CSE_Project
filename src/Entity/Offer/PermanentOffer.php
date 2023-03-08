<?php

namespace App\Entity\Offer;

use App\Repository\PermanentOfferRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermanentOfferRepository::class)]
class PermanentOffer extends Offer
{
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $validity_beginning = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $validity_ending = null;

    #[ORM\Column]
    private ?int $minimum_places = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValidityBeginning(): ?\DateTimeInterface
    {
        return $this->validity_beginning;
    }

    public function setValidityBeginning(\DateTimeInterface $validity_beginning): self
    {
        $this->validity_beginning = $validity_beginning;

        return $this;
    }

    public function getValidityEnding(): ?\DateTimeInterface
    {
        return $this->validity_ending;
    }

    public function setValidityEnding(\DateTimeInterface $validity_ending): self
    {
        $this->validity_ending = $validity_ending;

        return $this;
    }

    public function getMinimumPlaces(): ?int
    {
        return $this->minimum_places;
    }

    public function setMinimumPlaces(int $minimum_places): self
    {
        $this->minimum_places = $minimum_places;

        return $this;
    }
}