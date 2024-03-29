<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    private ?UploadedFile $file = null;

    public static function createFromPath(string $path, string $class): self
    {
        $file = new static;

        $file->setStoredName(str_replace("public/img/${class}\\", '', $path));

        $file->setExtension(pathinfo($path, PATHINFO_EXTENSION))
            ->setPath(str_replace('public', '', $path));

        return $file;
    }

    public function handleForm(Offer $offer): self
    {
        $this->setOffer($offer);
        $folder= "offer";
        if (!is_dir('./img/' . $folder))
            mkdir('./img/' . $folder);
        
        $ext = pathinfo($this->file->getClientOriginalName(), PATHINFO_EXTENSION);
        $name = str_replace('.' . $ext, '', $this->file->getClientOriginalName());
        $this->setOriginalName($name)
        ->setExtension($ext);
        
        $i = 0;
        if (file_exists('./img/' . $folder . '/' . $this->file->getClientOriginalName())) {
            $i = 1;
            while (file_exists('./img/' . $folder . '/' . $name . $i . $ext)) {
                $i++;
            }
            $i++;
        }
        
        $i = $i === 0 ? null : $i;
        $this->setStoredName($name . $i)
        ->setPath('/img/' . $folder . '/' . $name . $i . '.' . $ext);
        
        return $this;
    }

    public function handlePartner()
    {
        if (!is_dir('./img/partner')) mkdir('./img/partner');

        $ext = pathinfo($this->file->getClientOriginalName(), PATHINFO_EXTENSION);
        $name = str_replace('.' . $ext, '', $this->file->getClientOriginalName());
        $this->setOriginalName($name)
            ->setExtension($ext);

        $i = 0;
        if (file_exists('./img/partner/' . $this->file->getClientOriginalName())) {
            $i = 1;
            while (file_exists('./img/partner/' . $name . $i . $ext)) {
                $i++;
            }
            $i++;
        }
        $this->setStoredName($name . $i)
            ->setPath('/img/partner/' . $name . $i . '.' . $ext);
    }

    public function handleMember()
    {
        if (!is_dir('./img/member')) mkdir('./img/member');

        $ext = pathinfo($this->file->getClientOriginalName(), PATHINFO_EXTENSION);
        $name = str_replace('.' . $ext, '', $this->file->getClientOriginalName());
        $this->setOriginalName($name)
            ->setExtension($ext);

        $i = 0;
        if (file_exists('./img/member/' . $this->file->getClientOriginalName())) {
            $i = 1;
            while (file_exists('./img/member/' . $name . $i . $ext)) {
                $i++;
            }
            $i++;
        }
        $this->setStoredName($name . $i)
            ->setPath('/img/member/' . $name . $i . '.' . $ext);
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

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    public function setFile(?UploadedFile $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function __toString(): string
    {
        return $this->path;
    }
}
