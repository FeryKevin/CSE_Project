<?php

namespace App\Entity\Survey;

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
    private ?int $answer_number = null;

    #[ORM\ManyToOne(inversedBy: 'answers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?survey $survey_id = null;

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
        return $this->answer_number;
    }

    public function setAnswerNumber(int $answer_number): self
    {
        $this->answer_number = $answer_number;

        return $this;
    }

    public function getSurveyId(): ?survey
    {
        return $this->survey_id;
    }

    public function setSurveyId(?survey $survey_id): self
    {
        $this->survey_id = $survey_id;

        return $this;
    }
}
