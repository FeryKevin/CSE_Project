<?php

namespace App\Controller;

use App\Entity\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OfferController extends AbstractController
{
    #[Route(path: ('/offre/{id}'), name: 'offer_details')]
    public function details(Offer $offer)
    {
        dd($offer);
    }
}
