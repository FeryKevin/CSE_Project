<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $storedName = null;

    #[ORM\Column(length: 255)]
    private ?string $originalName = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column(length: 5)]
    private ?string $extension = null;

    #[ORM\ManyToOne(inversedBy: 'files')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Offer $offer = null;

    public static function createFromPath(string $path): self
    {
        $file = new static;

        $file->setStoredName(str_replace('public/img/offer\\', '', $path))
            ->setExtension(pathinfo($path, PATHINFO_EXTENSION))
            ->setPath($path);

        return $file;
    }

    public function handleForm(string $originalName): self
    {
        if (!is_dir('./img/partner'))
            mkdir('./img/partner');

        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $name = str_replace('.' . $ext, '', $originalName);
        $this->setOriginalName(str_replace('public/img/partner\\', '', $originalName))
            ->setExtension($ext);

        if (file_exists('./img/partner/' . $originalName)) {
            $i = 1;
            while (file_exists('./img/partner/' . $name . $i . $ext)) {
                $i++;
            }
            $i++;
        }

        $i = $i === 0 ? null : $i;
        $this->setStoredName($name . $i)
            ->setPath('./img/partner/' . $name . $i . '.' . $ext);

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStoredName(): ?string
    {
        return $this->storedName;
    }

    public function setStoredName(string $storedName): self
    {
        $this->storedName = $storedName;

        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): self
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): self
    {
        $this->offer = $offer;

        return $this;
    }
}