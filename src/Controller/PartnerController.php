<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Entity\Image;
use App\Form\Admin\PartnerType;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnerController extends AbstractController
{
    #[Route('/partner/create', name: 'partner_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();
            $check = true;

            foreach ($image as $images) {
                $extension = $images->guessExtension();

                if ('png' !== $extension && 'jpg' !== $extension && 'jpeg' !== $extension && 'webp' !== $extension && 'svg' !== $extension) {
                    $this->addFlash('error', 'Format d\'image incorrect');
                    $check = false;
                }
            }

            if ($check) {
                foreach ($images as $image) {
                    $fileName = md5(uniqid()) . '.' . $image->guessExtension();
                    $image->move(
                        $this->getParameter('project_directory'),
                        $fileName
                    );

                    $image = new Image();
                    $image->setImage($fileName);
                    $partner->setImage($image);
                }

                $manager->persist($partner);
                $manager->flush();

                $this->addFlash('success', 'Le partenaire a été ajouté');

                return $this->redirectToRoute('partner_create');
            }
        }

        return $this->render('/partner/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}