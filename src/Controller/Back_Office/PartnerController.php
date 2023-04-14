<?php

namespace App\Controller\Back_Office;

use App\Entity\Partner;
use App\Form\PartnerForm;
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

    #[Route(path: '/partners/delete', name: 'partner_delete', methods: ['POST'])]
    public function delete(PartnerRepository $partnerRepository, Request $request, EntityManagerInterface $em): Response
    {
        $post = json_decode($request->getContent(), true);

        $em->remove($partnerRepository->find($post['id']));
        $em->flush();

        return new Response('Partenaire has been deleted');
    }

    #[Route(path: '/partners/update', name: 'partner_update', methods: ['POST'])]
    public function updatePartner(PartnerRepository $partnerRepository, Request $request, EntityManagerInterface $em): Response
    {
        $post = json_decode($request->getContent(), true);

        $partner = $partnerRepository->find($post['id']);
        $partner->setName($post['name'] !== '' ? $post['name'] : $partner->getName())
            ->setDescription($post['description'] !== '' ? $post['description'] : $partner->getDescription())
            ->setWebsiteLink($post['websiteLink'] !== '' ? $post['websiteLink'] : $partner->getWebsiteLink());

        $em->persist($partner);
        $em->flush();

        return new Response('Partner has been udpate');
    }

    #[Route(path: '/partners/add', name: 'partner_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PartnerForm::class, new Partner());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partner = $form->getData();
            $partner->getImage()->handlePartner();

            $path = $partner->getImage()->getFile()->getRealPath();
            move_uploaded_file($path, '.' . $partner->getImage()->getPath());

            $em->persist($partner);
            $em->flush();

            return $this->redirectToRoute('partners');
        }

        return $this->render('back_office/partner/create.html.twig', ['form' => $form]);
    }

    #[Route(path: '/partners/img/{id}', name: 'change_partner_image', methods: ['POST'])]
    public function changePartner(PartnerRepository $partnerRepository, Request $request, EntityManagerInterface $em, Partner $partner): Response
    {
        $post = json_decode($request->getContent(), true);

        $partner->getImage()->setFile($request->files->get('image'));
        $partner->getImage()->handlePartner();

        $path = $partner->getImage()->getFile()->getRealPath();
        move_uploaded_file($path, '.' . $partner->getImage()->getPath());

        $em->persist($partner);
        $em->flush();

        return new Response('Image has been udpate');
    }
}
