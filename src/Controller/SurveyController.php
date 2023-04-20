<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Form\SurveyFormType;
use App\Repository\SurveyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SurveyController extends AbstractController
{
    public SurveyRepository $surveyRepository;

    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function surveyForm(): Response
    {
        $survey = $this->surveyRepository->findActive();
        if (empty($survey)) {
            return $this->render('survey.html.twig');
        }

        $form = $this->createForm(SurveyFormType::class, $survey[0], ['action' => $this->generateUrl('handle_survey')]);

        return $this->render(
            'survey.html.twig',
            [
                'form' => $form->createView(),
                'survey' => $survey[0],
            ]
        );
    }

    #[Route(path: 'surveyHandler', name: 'handle_survey', methods: ['POST'])]
    public function handleSurveyForm(Request $request, EntityManagerInterface $em)
    {
        $survey = $this->surveyRepository->find($request->get('survey'));
        if (!array_key_exists('answers', $request->get('survey_form')))
            return $this->redirect($request->headers->get('referer'));

        $answer = $survey->getAnswers()[$request->get('survey_form')['answers']];
        $answer->setAnswerNumber($answer->getAnswerNumber() + 1);
        $em->persist($answer);
        $em->flush();
        $this->addFlash('SurveySuccess', 'Votre réponsé à été enregistée');

        return $this->redirect($request->headers->get('referer'));
    }
}
