<?php

namespace App\Controller;

use \DateTime;
use App\Entity\Offer;
use App\Form\LimitedOfferType;
use App\Form\PermanentOfferType;
use App\Repository\CSERepository;
use App\Repository\FileRepository;
use App\Repository\OfferRepository;
use App\Service\Newsletter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfferController extends AbstractController
{
    // Partie admin
    #[Route(path: "/admin/offer/create_permanent", name: "create_permanent_offer")]
    public function createPermanentOffer(EntityManagerInterface $em,
        Request $request,
        Newsletter $mailer): Response
    {
        $offer = new Offer();

        $form = $this->createForm(PermanentOfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offer->setType("permanent");

            $now = new DateTime('now');
            $now_string = $now->format('Y-m-d H:i:s');
            $now = date_create_from_format('Y-m-d H:i:s', $now_string);

            $offer->setPublishedAt($now);

            foreach ($offer->getImages() as $img) {
                $img->handleForm($offer);
                $path = $img->getFile()->getRealPath();
                move_uploaded_file($path, '.' . $img->getPath());
            }

            $em->persist($offer);
            $em->flush();

            $mailer->sendNewOffer($offer);

            return $this->redirectToRoute('admin_offers');
        }

        return $this->render('back_office/offers/create_offer.html.twig', [
            'form' => $form->createView(),
            'type' => 'permanente'
        ]);
    }

    #[Route(path: "/admin/offer/create_limited", name: "create_limited_offer")]
    public function createLimitedOffer(EntityManagerInterface $em,
        Request $request,
        Newsletter $mailer): Response
    {
        $offer = new Offer();

        $form = $this->createForm(LimitedOfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offer->setType("limited");

            $now = new DateTime('now');
            $now_string = $now->format('Y-m-d H:i:s');
            $now = date_create_from_format('Y-m-d H:i:s', $now_string);

            $offer->setPublishedAt($now);

            foreach ($offer->getImages() as $img) {
                $img->handleForm($offer);
                $path = $img->getFile()->getRealPath();
                move_uploaded_file($path, '.' . $img->getPath());
            }

            $em->persist($offer);
            $em->flush();

            $mailer->sendNewOffer($offer);

            return $this->redirectToRoute('admin_offers');
        }

        return $this->render('back_office/offers/create_offer.html.twig', [
            'form' => $form->createView(),
            'type' => 'limitée'
        ]);
    }

    #[Route(path: "/admin/offers", name: "admin_offers")]
    public function offers(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findAll();

        return $this->render('back_office/offers/offers.html.twig', [
            'offers' => $offers,
        ]);
    }

    #[Route(path: "/admin/offer/{id}", name: "offer", methods: ['GET', 'POST'])]
    public function offer(OfferRepository $offerRepository,
        int $id,
        Request $request): Response
    {
        $id = $request->get(key: 'id');

        if ($offer = $offerRepository->find($id)) {
            if ($offer->getType() == "permanent") {
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
        }
    }

    #[Route(path: "/admin/offer/{id}/update", name: "update_offer", methods: ['GET', 'POST'])]
    public function update(OfferRepository $offerRepository,
        int $id,
        EntityManagerInterface $em,
        Request $request,
        Newsletter $newsletter): Response
    {
        $id = $request->get(key: 'id');

        if ($offer = $offerRepository->find($id)) {
            if ($offer->getType() == "permanent") {
                $form = $this->createForm(PermanentOfferType::class, $offer, [
                    'on_edit' => true,
                ]);
            } else {
                $form = $this->createForm(LimitedOfferType::class, $offer, [
                    'on_edit' => true,
                ]);
            }

            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                    $offer = $form->getData();

                    foreach ($offer->getImages() as $img) {
                        $img->handleForm($offer);
                        $path = $img->getFile()->getRealPath();
                        move_uploaded_file($path, '.' . $img->getPath());
                    }

                    $now = new DateTime('now');
                    $now_string = $now->format('Y-m-d H:i:s');
                    $now = date_create_from_format('Y-m-d H:i:s', $now_string);

                    $offer->setUpdatedAt($now);

                    $em->persist($offer);
                    $em->flush();

                    if ($offer->getType() == "limited") {
                        $newsletter->sendUpdateOffer($offer);
                    }

                    return $this->redirectToRoute('offer', ['id' => $id]);
                }
            }

            return $this->render('back_office/offers/edit_offer.html.twig', [
                'offer' => $offer,
                'form' => $form->createView(),
            ]);
        }
    }

    #[Route(path: "/admin/offers/delete_image", name: "delete_offer_image", methods: ['POST', 'OPTIONS', 'DELETE'])]
    public function deleteImage(FileRepository $fileRepository,
        Request $request,
        EntityManagerInterface $manager): Response
    {
        $post = json_decode($request->getContent(), true);

        $file = $fileRepository->find($post['id']);
        $fileName = $file->getStoredName();
        $fileExtension = $file->getExtension();
        $filePath = $this->getParameter('kernel.project_dir')
        . '/public/img/offer/' . $fileName . '.' . $fileExtension;
        unlink($filePath);

        $manager->remove($file);
        $manager->flush();

        return new Response('Survey has been updated');
    }

    #[Route(path: "/admin/offer/{id}/delete", name: "delete_offer", methods: ['GET', 'DELETE'])]
    public function deleteOffer(OfferRepository $offerRepository,
        int $id,
        EntityManagerInterface $manager): Response
    {
        if ($offer = $offerRepository->find($id)) {
            $manager->remove($offer);
            $manager->flush();
            $this->addFlash('success', 'L\'offre a bien été supprimée');

            return $this->redirectToRoute('admin_offers');
        }
    }

    // Partie publique
    #[Route(path: ('/offre/{id}'), name: 'offer_details')]
    public function details(Offer $offer,
        CSERepository $cseRepository): Response
    {
        $cse = $cseRepository->findAll()[0];

        return $this->render('offers/details.html.twig', [
            'offer' => $offer,
            'email' => $cse->getEmail(),
        ]);
    }

    // Partie publique
    #[Route(path: '/offres', name: 'offers')]
    public function offersIndex(): Response
    {
        return $this->redirectToRoute('limited_offers');
    }

    #[Route(path: '/offres/permanentes', name: 'permanent_offers'),
        Route(path: '/offres/permanentes/page/{page}', name: 'pagined_permanent_offers')]
    public function permanentOffers(CSERepository $cseRepository,
        OfferRepository $offerRepository,
        int $page = 1): Response
    {
        $pagination = $offerRepository->findWithPaginator($page, $limit = 8, $type = 'permanent');

        $cse = $cseRepository->findAll()[0];

        return $this->render('offers/index.html.twig', [
                'pagination' => $pagination,
                'email' => $cse->getEmail(),
                'type' => 'permanent',
            ]
        );
    }

    #[Route(path: '/offres/limitees', name: 'limited_offers'),
        Route(path: '/offres/limitees/page/{page}', name: 'pagined_limited_offers')]
    public function limitedOffers(CSERepository $cseRepository,
        OfferRepository $offerRepository,
        int $page = 1): Response
    {
        $pagination = $offerRepository->findWithPaginator($page, $limit = 8, $type = 'limited');

        $cse = $cseRepository->findAll()[0];

        return $this->render(
            'offers/index.html.twig',
            [
                'pagination' => $pagination,
                'email' => $cse->getEmail(),
                'type' => 'limited',
            ]
        );
    }
}
