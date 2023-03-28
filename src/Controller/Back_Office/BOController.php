<?php

namespace App\Controller\Back_Office;

use App\Entity\Survey;
use App\Repository\ContactRepository;
use App\Repository\SurveyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BOController extends AbstractController
{
    #[Route(path: '/admin', name: 'admin')]
    public function home(): Response
    {
        return $this->render('back_office/back_office.html.twig', []);
    }

    #[Route(path: '/admin/contacts', name: 'admin_contacts')]
    public function contacts(ContactRepository $contactRepository): Response
    {
        return $this->render('back_office/contacts.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    #[Route(path: '/admin/surveys', name: 'admin_surveys')]
    public function surveys(SurveyRepository $surveyRepository, Request $re): Response
    {
        return $this->render('back_office/surveys.html.twig', [
            'surveys' => $surveyRepository->findAll(),
        ]);
    }

    #[Route(path: '/admin/survey_status', name: 'admin_survey_status', methods: ['POST', 'OPTIONS'])]
    public function surveyStatus(SurveyRepository $surveyRepository, Request $request, EntityManagerInterface $em): Response
    {
        $post = json_decode($request->getContent(), true);
        if ((bool)$post['status']) {
            $oldSurvey = $surveyRepository->findRandomOneActive();
            if (!empty($oldSurvey)) {
                $oldSurvey->setActive(0);
                $em->persist($oldSurvey);
            }
        }
        $survey = $surveyRepository->find($post['id']);

        $survey->setActive($post['status']);

        $em->persist($survey);
        $em->flush();

        return new Response('Survey has been updated');
    }

    #[Route(path: '/admin/survey/update/{id}', name: 'admin_survey_update', methods: ['POST', 'OPTIONS'])]
    public function surveyQuestion(Survey $survey, Request $request, EntityManagerInterface $em): Response
    {
        $post = json_decode($request->getContent(), true);
        $survey->setQuestion($post['question']);

        $em->persist($survey);
        $em->flush();

        return new Response('Survey has been updated');
    }
}
