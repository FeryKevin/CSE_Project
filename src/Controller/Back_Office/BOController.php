<?php

namespace App\Controller\Back_Office;

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

    #[Route(path: '/admin/survey_status', name: 'admin_survey_status', methods: ['POST'])]
    public function surveyStatus(SurveyRepository $surveyRepository, Request $request, EntityManagerInterface $em): Response
    {
        $post = json_decode($request->getContent(), true);
        $survey = $surveyRepository->find($post['id']);

        $survey->setActive($post['status']);

        $em->persist($survey);
        $em->flush();

        return new Response('Survey has been updated');
    }
}
