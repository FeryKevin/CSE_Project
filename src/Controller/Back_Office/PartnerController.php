<?php

namespace App\Controller\Back_Office;

use App\Entity\Partner;
use App\Entity\File;
use App\Form\Admin\PartnerType;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class PartnerController extends AbstractController
{
    #[Route('/partners', name: 'partners')]
    public function index(PartnerRepository $partnerRepository): Response
    {
        $partners = $partnerRepository->findAll();

        return $this->render('/back_office/partner/index.html.twig', [
            'partners' => $partners,
        ]);
    }
}
