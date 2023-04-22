<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SliderController extends AbstractController
{
    #[Route(name: 'slider')]
    public function slider(PartnerRepository $partnerRepository): Response
    {
        $partners = $partnerRepository->findBy3();

        return $this->render('slider.html.twig', [
            'partners' => $partners,
        ]);
    }
}
