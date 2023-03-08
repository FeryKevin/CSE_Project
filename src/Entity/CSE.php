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
    private ?string $presentation_home = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $presentation_about = null;

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
        return $this->presentation_home;
    }

    public function setPresentationHome(string $presentation_home): self
    {
        $this->presentation_home = $presentation_home;

        return $this;
    }

    public function getPresentationAbout(): ?string
    {
        return $this->presentation_about;
    }

    public function setPresentationAbout(string $presentation_about): self
    {
        $this->presentation_about = $presentation_about;

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
