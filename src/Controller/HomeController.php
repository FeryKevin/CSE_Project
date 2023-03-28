<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Repository\NewsletterRepository;
use App\Repository\OfferRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HomeController extends AbstractController
{
    private OfferRepository $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    #[Route(path: '/newsletterInscription', name: 'newsletter_inscription', methods: ['POST'])]
    public function newsletterInscription(Request $request, EntityManagerInterface $em, ValidatorInterface $validator)
    {
        if (!$this->isCsrfTokenValid('newsletter', $request->request->get('token')))
            return $this->redirect('/');
        $newsletter = new Newsletter();
        $newsletter->setEmail($request->request->get('email'))
            ->setIsRegistered(true)
            ->setRegisteredAt(new \Datetime());

        $errors = $validator->validate($newsletter);

        if (count($errors) === 0) {
            $this->addFlash('success', 'Vous avez bien été inscrit(e) à la newsletter');

            $em->persist($newsletter);
            $em->flush();
        } else {
            $this->addFlash('fail', 'Erreur lors de l\'inscription');
        }

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route(path: '/', name: 'home'), Route(path: '/page/{page}', name: 'paginedHome')]
    public function home(int $page = 1): Response
    {
        $pagination = $this->offerRepository->findWithPaginator($page);

        return $this->render(
            'index.html.twig',
            [
                'pagination' => $pagination,
            ]
        );
    }

    public function renderNewsletter(): Response
    {
        $form = $this->createForm(NewsletterType::class, null, ['action' => $this->generateUrl('newsletter_inscription')]);

        return $this->render('newsletterInscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}