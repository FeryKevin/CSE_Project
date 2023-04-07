<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Newsletter;
use App\Form\ContactType;
use App\Form\NewsletterType;
use App\Repository\CSERepository;
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

    #[Route(path: '/', name: 'home'), Route(path: '/page/{page}', name: 'paginedHome')]
    public function home(CSERepository $cseRepository, int $page = 1): Response
    {
        $pagination = $this->offerRepository->findWithPaginator($page);

        $cse = $cseRepository->findAll()[0];

        return $this->render(
            'index.html.twig',
            [
                'pagination' => $pagination,
                'text' => $cse->getPresentationHome(),
                'email' => $cse->getEmail(),
            ]
        );
    }

    #[Route(path: '/a_propos_de_nous', name: 'aboutUs')]
    public function aboutUs(CSERepository $cseRepository)
    {
        $cse = $cseRepository->findAll()[0];

        return $this->render('aboutUs.html.twig', [
            'text' => $cse->getPresentationAbout(),
            'rules' => $cse->getRules(),
            'actions' => $cse->getActions(),
        ]);
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
            $this->addFlash('NewsletterSuccess', 'Vous avez bien été inscrit(e) à la newsletter');

            $em->persist($newsletter);
            $em->flush();
        } else {
            $this->addFlash('fail', 'Erreur lors de l\'inscription');
        }

        return $this->redirect($request->headers->get('referer'));
    }

    public function renderNewsletter(): Response
    {
        $form = $this->createForm(NewsletterType::class, null, ['action' => $this->generateUrl('newsletter_inscription')]);

        return $this->render('newsletterInscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ContactType::class, new Contact());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($form->getData());
            $em->flush();

            $this->addFlash('contact-success', 'Le message a été envoyé');

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact.html.twig', ['form' => $form]);
    }
}
