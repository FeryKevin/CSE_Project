<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Repository\CSERepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OfferController extends AbstractController
{
    #[Route(path: ('/offre/{id}'), name: 'offer_details')]
    public function details(Offer $offer, CSERepository $cseRepository)
    {
        $cse = $cseRepository->findAll()[0];

        return $this->render('offer/details.html.twig', [
            'offer' => $offer,
            'email' => $cse->getEmail(),
        ]);
    }
}
