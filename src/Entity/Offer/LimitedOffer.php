<?php

namespace App\Entity\Offer;

use App\Repository\LimitedOfferRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LimitedOfferRepository::class)]
class LimitedOffer extends Offer
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $display_beginning = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $display_ending = null;

    #[ORM\Column]
    private ?int $display_number = null;

    public function getDisplayBeginning(): ?\DateTimeInterface
    {
        return $this->display_beginning;
    }

    public function setDisplayBeginning(\DateTimeInterface $display_beginning): self
    {
        $this->display_beginning = $display_beginning;

        return $this;
    }

    public function getDisplayEnding(): ?\DateTimeInterface
    {
        return $this->display_ending;
    }

    public function setDisplayEnding(\DateTimeInterface $display_ending): self
    {
        $this->display_ending = $display_ending;

        return $this;
    }

    public function getDisplayNumber(): ?int
    {
        return $this->display_number;
    }

    public function setDisplayNumber(int $display_number): self
    {
        $this->display_number = $display_number;

        return $this;
    }
}