<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Entity\File;
use App\Form\PartnerForm;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnerController extends AbstractController
{
    #[Route('/admin/partner', name: 'partner_index')]
    public function index(PartnerRepository $partnerRepository): Response
    {
        $partners = $partnerRepository->findAll();

        return $this->render('/back_office/partner/index.html.twig', [
            'partners' => $partners,
        ]);
    }

    #[Route('/admin/partner/create', name: 'partner_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $partner = new Partner();
        $form = $this->createForm(PartnerForm::class, $partner);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partner = $form->getData();
            $path = $partner->getImage()->getOriginalName();
            $partner->getImage()->handleForm($request->files->get('partner')['image']['originalName']->getClientOriginalName());

            move_uploaded_file($path, $partner->getImage()->getPath());
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

    #[Route('/admin/partner/delete/{id}', name: 'partner_delete', methods: ['POST'])]
    public function delete(Request $request, Partner $partner, PartnerRepository $partnerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $partner->getId(), $request->request->get('_token'))) {
            $partnerRepository->remove($partner, true);
        }

        return $this->redirectToRoute('partner_index', [], Response::HTTP_SEE_OTHER);
    }
}