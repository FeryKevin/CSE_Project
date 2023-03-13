<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\Column]
    private ?int $answerNumber = null;

    #[ORM\ManyToOne(inversedBy: 'answers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?survey $survey = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getAnswerNumber(): ?int
    {
        return $this->answerNumber;
    }

    public function setAnswerNumber(int $answerNumber): self
    {
        $this->answerNumber = $answerNumber;

        return $this;
    }

    public function getSurvey(): ?survey
    {
        return $this->survey;
    }

    public function setSurvey(?survey $survey): self
    {
        $this->survey = $survey;

        return $this;
    }
}
