<?php

namespace App\Entity;

use App\Repository\CSERepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CSERepository::class)]
class CSE
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $presentationHome = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $presentationAbout = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $rules = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $actions = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresentationHome(): ?string
    {
        return $this->presentationHome;
    }

    public function setPresentationHome(?string $presentationHome): self
    {
        $this->presentationHome = $presentationHome;

        return $this;
    }

    public function getPresentationAbout(): ?string
    {
        return $this->presentationAbout;
    }

    public function setPresentationAbout(string $presentationAbout): self
    {
        $this->presentationAbout = $presentationAbout;

        return $this;
    }

    public function getRules(): ?string
    {
        return $this->rules;
    }

    public function setRules(string $rules): self
    {
        $this->rules = $rules;

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

    public function getActions(): ?string
    {
        return $this->actions;
    }

    public function setActions(string $actions): self
    {
        $this->actions = $actions;

        return $this;
    }
}
