<?php

namespace App\Controller;

use \DateTime;
use App\Entity\Offer;
use App\Form\LimitedOfferType;
use App\Form\PermanentOfferType;
use App\Repository\FileRepository;
use App\Repository\OfferRepository;
use App\Service\Newsletter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfferController extends AbstractController
{
    // Partie admin
    #[Route(path: "/admin/offer/create", name: "create_offer")]
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

            $offer->setPublishedAt($now);

            foreach ($offer->getImages() as $img)
            {
                $img->handleForm($offer);
                $path = $img->getFile()->getRealPath();
                move_uploaded_file($path, '.'.$img->getPath());
            }
            
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

                $offer->setPublishedAt($now);

                foreach ($offer->getImages() as $img)
                {
                    $img->handleForm($offer);
                    $path = $img->getFile()->getRealPath();
                    move_uploaded_file($path, '.'.$img->getPath());
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

    #[Route(path: "/admin/offers", name: "offers")]
    public function offers(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findAll();

        return $this->render('back_office/offers/offers.html.twig', [
            'offers' => $offers,
        ]);
    }

    #[Route(path: "/admin/offer/{id}", name: "offer", methods: ['GET', 'POST'])]
    public function offer(OfferRepository $offerRepository, int $id, Request $request): Response
    {
        $id = $request->get(key: 'id');

        if($offer = $offerRepository->find($id))
        {
            if ($offer->getType() == "permanent")
            {
                $permanentValidityBeginning = $offer->getPermanentValidityBeginning()->format('Y-m-d H:i:s');
                $permanentValidityEnding = $offer->getPermanentValidityEnding()->format('Y-m-d H:i:s');

                return $this->render('back_office/offers/offer.html.twig', [
                    'offer' => $offer,
                    'validity_beginning' => $permanentValidityBeginning,
                    'validity_ending' => $permanentValidityEnding,
                ]);
            } else {
                $limitedDisplayBeginning = $offer->getLimitedDisplayBeginning()->format('Y-m-d H:i:s');
                $limitedDisplayEnding = $offer->getLimitedDisplayEnding()->format('Y-m-d H:i:s');

                return $this->render('back_office/offers/offer.html.twig', [
                    'offer' => $offer,
                    'display_beginning' => $limitedDisplayBeginning,
                    'display_ending' => $limitedDisplayEnding,
                ]);
            }
        } else {
            return $this->render('back_office/offer_error.html.twig', [
                'id' => $id,
                'offer' => $offer,
            ]);
        }
    }

    #[Route(path: "/admin/offer/{id}/update", name: "update_offer", methods: ['GET', 'POST'])]
    public function update(OfferRepository $offerRepository, int $id, EntityManagerInterface $em, Request $request, Newsletter $newsletter): Response
    {
        $id = $request->get(key: 'id');

        if($offer = $offerRepository->find($id))
        {
            if ($offer->getType() == "permanent")
            {
                $form = $this->createForm(PermanentOfferType::class, $offer, [
                    'on_edit' => true,
                ]);
            } else {
                $form = $this->createForm(LimitedOfferType::class, $offer, [
                    'on_edit' => true,
                ]);
            }

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $offer = $form->getData();

                foreach ($offer->getImages() as $img)
                {
                    $img->handleForm($offer);
                    $path = $img->getFile()->getRealPath();
                    move_uploaded_file($path, '.'.$img->getPath());
                }
                
                $em->persist($offer);
                $em->flush();

                // $newsletter->sendUpdateOffer($offer);
                
                return $this->redirectToRoute('offer', ['id' => $id]);
            }
            
            return $this->render('back_office/offers/edit_offer.html.twig', [
                'offer' => $offer,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->render('back_office/offer_error.html.twig', [
                'id' => $id,
            ]);
        }
    }
    
    #[Route(path: "/admin/offers/delete_image", name: "delete_offer_image", methods: ['POST', 'OPTIONS', 'DELETE'])]
    public function deleteImage(FileRepository $fileRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $post = json_decode($request->getContent(), true);

        $file = $fileRepository->find($post['id']);

        $fileName = $file->getStoredName();
        $fileExtension = $file->getExtension();
        $filePath = $this->getParameter('kernel.project_dir') . '/public/img/offer/' . $fileName . '.' . $fileExtension;
        unlink($filePath);

        $manager->remove($file);
        $manager->flush();

        return new Response('Survey has been updated');
    }
    
    #[Route(path: "/admin/offer/{id}/delete", name: "delete_offer", methods: ['GET', 'DELETE'])]
    public function deleteOffer(OfferRepository $offerRepository, int $id, EntityManagerInterface $manager): Response
    {
        if($offer = $offerRepository->find($id))
        {
            $manager->remove($offer);
            $manager->flush();

            $this->addFlash('success', 'L\'offre a bien été supprimée');

            return $this->redirectToRoute('offers');
        } else {
            return $this->render('back_office/offer_error.html.twig', [
                'id' => $id,
            ]);
        }
    }

    // Partie publique
    #[Route(path: ('/offre/{id}'), name: 'offer_details')]
    public function details(Offer $offer)
    {
        return $this->render('offer/details.html.twig', [
            'offer' => $offer,
        ]);
    }
}