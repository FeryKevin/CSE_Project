<?php

namespace App\Controller\Back_Office;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
