<?php

namespace App\Controller;

use \DateTime;
use App\Entity\Offer;
use App\Form\LimitedOfferType;
use App\Form\PermanentOfferType;
use App\Repository\FileRepository;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfferController extends AbstractController
{
    // Partie publique
    #[Route(path: ('/offre/{id}'), name: 'offer_details')]
    public function details(Offer $offer)
    {
        return $this->render('offer/details.html.twig', [
            'offer' => $offer,
        ]);
    }

    // Partie admin
    #[Route(path: "/admin/offers", name: "offers")]
    public function offers(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findAll();

        return $this->render('back_office/offers/offers.html.twig', [
            'offers' => $offers,
        ]);
    }

    #[Route(path: "/admin/offer/{slug}", name: "offer", methods: ['GET', 'POST', 'DELETE'])]
    public function offer(OfferRepository $offerRepository, FileRepository $fileRepository, string $slug, EntityManagerInterface $em, Request $request): Response
    {
        $slug = $request->get(key: 'slug');

        if($offer = $offerRepository->findOneBy(['name'=> $slug]))
        {
            // $images = $fileRepository->findOneBy(['id'=> $offer->getImages()]);

            if ($offer->getType() == "permanent")
            {
                $form = $this->createForm(PermanentOfferType::class, $offer);
                $form->handleRequest($request);
            } else {
                $form = $this->createForm(LimitedOfferType::class, $offer);
                $form->handleRequest($request);
            }

            if ($form->isSubmitted() && $form->isValid())
            {
                $em->persist($offer);
                $em->flush();
            }
            return $this->render('back_office//offers/offer.html.twig', [
                'offer' => $offer,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->render('back_office/offer_error.html.twig', [
                'slug' => $slug,
            ]);
        }
    }

    #[Route(path: "/admin/offers/create", name: "create_offer")]
    public function createOffer(EntityManagerInterface $em, Request $request): Response
    {
        $offer = new Offer();
        $formPermanent = $this->createForm(PermanentOfferType::class, $offer);
        $formPermanent->handleRequest($request);
        $formLimited = $this->createForm(LimitedOfferType::class, $offer);
        $formLimited->handleRequest($request);

        if ($formPermanent->isSubmitted() && $formPermanent->isValid())
        {
            $offer->setType("permanent");

            $now = new DateTime('now');
            $now_string = $now->format('Y-m-d H:i:s');
            $now = date_create_from_format('Y-m-d H:i:s', $now_string);

            if ($offer->getPublishedAt() != "")
            {
                $offer->setUpdatedAt($now);
            } else {
                $offer->setPublishedAt($now);
            }
            
            // On envoie en base de donnée la nouvelle catégorie.
            $em->persist($offer);
            $em->flush();

            return $this->redirectToRoute('offers');
        } else {
            if ($formLimited->isSubmitted() && $formLimited->isValid())
            {
                $offer->setType("limited");
                
                $now = new DateTime('now');
                $now_string = $now->format('Y-m-d H:i:s');
                $now = date_create_from_format('Y-m-d H:i:s', $now_string);

                if ($offer->getPublishedAt() != "")
                {
                    $offer->setUpdatedAt($now);
                } else {
                    $offer->setPublishedAt($now);
                }
                // On envoie en base de donnée la nouvelle catégorie.
                $em->persist($offer);
                $em->flush();

                return $this->redirectToRoute('offers');
            }
        }
        
        return $this->render('back_office/offers/create_offer.html.twig', [
            'form_permanent' => $formPermanent->createView(),
            'form_limited' => $formLimited->createView(),
        ]);
    }

    // #[Route(path: "/admin/offers/update/{slug}", name: "bo_update_offer", methods: ['GET'])]
    // public function updateOffer(OfferRepository $offerRepository, string $slug, EntityManagerInterface $manager): Response
    // {
    //     if($offer = $offerRepository->findOneBy(['slug'=> $slug]))
    //     {
    //         $manager->persist($offer);
    //         $manager->flush();

    //         $this->addFlash('success', 'Le projet a bien été modifié');

    //         return $this->redirect('offers');
    //     } else {
    //         return $this->render('offers/error.html.twig', [
    //             'slug' => $slug,
    //         ]);
    //     }
    // }
    
    #[Route(path: "/admin/offers/delete/{slug}", name: "delete_offer", methods: ['GET', 'DELETE'])]
    public function deleteOffer(OfferRepository $offerRepository, string $slug, EntityManagerInterface $manager): Response
    {
        if($offer = $offerRepository->findOneBy(['name'=> $slug]))
        {
            $manager->remove($offer);
            $manager->flush();

            $this->addFlash('success', 'L\'offre a bien été supprimée');

            return $this->redirectToRoute('offers');
        } else {
            return $this->render('back_office/offer_error.html.twig', [
                'slug' => $slug,
            ]);
        }
    }
}
