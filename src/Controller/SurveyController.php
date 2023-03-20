<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Form\SurveyFormType;
use App\Repository\SurveyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SurveyController extends AbstractController
{
    public function surveyForm(SurveyRepository $rep): Response
    {
        $survey = $rep->findRandomOneActive();
        $form = $this->createForm(SurveyFormType::class, $survey);

        return $this->render(
            'survey.html.twig',
            [
                'form' => $form->createView(),
                'survey' => $survey,
            ]
        );
    }

    #[Route(path: '/survey')]
    public function suvery()
    {
        return $this->render('test.html.twig');
    }
}
