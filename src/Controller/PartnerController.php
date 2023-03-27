<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Entity\File;
use App\Form\Admin\PartnerType;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnerController extends AbstractController
{
    #[Route('/admin/partner/create', name: 'partner_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partner = $form->getData();
            $partner->getImage()->handleForm($request->files->get('partner')['image']['originalName']->getClientOriginalName());

            dd($partner);
            $manager->persist($partner->getImage());
            $manager->persist($partner);
            $manager->flush();

            $this->addFlash('success', 'Le partenaire a été ajouté.');

            return $this->redirectToRoute('partner_create');
        }

        return $this->render('/back_office/partner/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}