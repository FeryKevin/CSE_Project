<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
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
    private ?\DateTimeInterface $publishedAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $permanentValidityBeginning = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $permanentValidityEnding = null;

    #[ORM\Column(nullable: true)]
    private ?int $permanentMinimumPlaces = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $limitedDisplayBeginning = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $limitedDisplayEnding = null;

    #[ORM\Column(nullable: true)]
    private ?int $limitedDisplayNumber = null;

    #[ORM\OneToMany(mappedBy: 'offer', targetEntity: File::class, cascade: ["persist", "remove"])]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPermanentValidityBeginning(): ?\DateTimeInterface
    {
        return $this->permanentValidityBeginning;
    }

    public function setPermanentValidityBeginning(?\DateTimeInterface $permanentValidityBeginning): self
    {
        $this->permanentValidityBeginning = $permanentValidityBeginning;

        return $this;
    }

    public function getPermanentValidityEnding(): ?\DateTimeInterface
    {
        return $this->permanentValidityEnding;
    }

    public function setPermanentValidityEnding(?\DateTimeInterface $permanentValidityEnding): self
    {
        $this->permanentValidityEnding = $permanentValidityEnding;

        return $this;
    }

    public function getPermanentMinimumPlaces(): ?int
    {
        return $this->permanentMinimumPlaces;
    }

    public function setPermanentMinimumPlaces(?int $permanentMinimumPlaces): self
    {
        $this->permanentMinimumPlaces = $permanentMinimumPlaces;

        return $this;
    }

    public function getLimitedDisplayBeginning(): ?\DateTimeInterface
    {
        return $this->limitedDisplayBeginning;
    }

    public function setLimitedDisplayBeginning(?\DateTimeInterface $limitedDisplayBeginning): self
    {
        $this->limitedDisplayBeginning = $limitedDisplayBeginning;

        return $this;
    }

    public function getLimitedDisplayEnding(): ?\DateTimeInterface
    {
        return $this->limitedDisplayEnding;
    }

    public function setLimitedDisplayEnding(?\DateTimeInterface $limitedDisplayEnding): self
    {
        $this->limitedDisplayEnding = $limitedDisplayEnding;

        return $this;
    }

    public function getLimitedDisplayNumber(): ?int
    {
        return $this->limitedDisplayNumber;
    }

    public function setLimitedDisplayNumber(?int $limitedDisplayNumber): self
    {
        $this->limitedDisplayNumber = $limitedDisplayNumber;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(File $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setOffer($this);
        }

        return $this;
    }

    public function removeImage(File $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getOffer() === $this) {
                $image->setOffer(null);
            }
        }

        return $this;
    }
}
