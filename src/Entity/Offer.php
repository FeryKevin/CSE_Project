<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $published_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'offer_id', targetEntity: OfferImage::class)]
    private Collection $offerImages;

    public function __construct()
    {
        $this->offerImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->published_at;
    }

    public function setPublishedAt(\DateTimeInterface $published_at): self
    {
        $this->published_at = $published_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, OfferImage>
     */
    public function getOfferImages(): Collection
    {
        return $this->offerImages;
    }

    public function addOfferImage(OfferImage $offerImage): self
    {
        if (!$this->offerImages->contains($offerImage)) {
            $this->offerImages->add($offerImage);
            $offerImage->setOfferId($this);
        }

        return $this;
    }

    public function removeOfferImage(OfferImage $offerImage): self
    {
        if ($this->offerImages->removeElement($offerImage)) {
            // set the owning side to null (unless already changed)
            if ($offerImage->getOfferId() === $this) {
                $offerImage->setOfferId(null);
            }
        }

        return $this;
    }
}
