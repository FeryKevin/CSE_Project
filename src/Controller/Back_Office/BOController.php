<?php

namespace App\Controller\Back_Office;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BOController extends AbstractController
{
    #[Route(path: '/admin', name: 'admin')]
    public function home(): Response
    {

        return $this->render('back_office/back_office.html.twig', [
        ]);
    }
}
     