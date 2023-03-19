<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Repository\NewsletterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'home')]
    public function home(): Response
    {

        return $this->render('index.html.twig', []);
    }

    #[Route(path: '/test', name: 'home')]
    public function test(Request $request, EntityManagerInterface $em): Response
    {
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newsletter = $form->getData();
            $newsletter->setIsRegistered(true);
            $newsletter->setRegisteredAt(new \Datetime());
            $this->addFlash('success', 'Vous avez bien été inscrit(e) à la newsletter');

            $em->persist($newsletter);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        return $this->render('newsletterInscription.html.twig', [
            'form' => $form,
        ]);
    }
}
