<?php

namespace App\Entity;

use App\Repository\OfferImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfferImageRepository::class)]
class OfferImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'offerImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?offer $offer_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getOfferId(): ?offer
    {
        return $this->offer_id;
    }

    public function setOfferId(?offer $offer_id): self
    {
        $this->offer_id = $offer_id;

        return $this;
    }
}
