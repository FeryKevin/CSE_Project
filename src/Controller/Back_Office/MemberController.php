<?php

namespace App\Controller\Back_Office;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class MemberController extends AbstractController
{
    #[Route(path: '/members', name: 'update_members')]
    public function members(MemberRepository $memberRepository): Response
    {
        return $this->render('back_office/member/update_members.html.twig', ['members' => $memberRepository->findAll()]);
    }

    #[Route(path: '/members/delete', name: 'delete_members', methods: ['POST'])]
    public function deleteMembers(MemberRepository $memberRepository, Request $request, EntityManagerInterface $em): Response
    {
        $post = json_decode($request->getContent(), true);

        $em->remove($memberRepository->find($post['id']));
        $em->flush();

        return new Response('Member has been deleted');
    }

    #[Route(path: '/members/update', name: 'udpate_member', methods: ['POST'])]
    public function updateMember(MemberRepository $memberRepository, Request $request, EntityManagerInterface $em): Response
    {
        $post = json_decode($request->getContent(), true);

        $member = $memberRepository->find($post['id']);
        $member->setName($post['name'] !== '' ? $post['name'] : $member->getName())
            ->setFirstname($post['firstname'] !== '' ? $post['firstname'] : $member->getFirstname());

        $em->persist($member);
        $em->flush();

        return new Response('Member has been udpate');
    }

    #[Route(path: '/members/add', name: 'create_member')]
    public function createMember(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(MemberType::class, new Member());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $member = $form->getData();
            $member->getImage()->handleMember();

            $path = $member->getImage()->getFile()->getRealPath();
            move_uploaded_file($path, '.' . $member->getImage()->getPath());

            $em->persist($member);
            $em->flush();

            return $this->redirectToRoute('aboutUs');
        }

        return $this->render('back_office/member/add.html.twig', ['form' => $form]);
    }

    #[Route(path: '/members/img', name: 'change_member_image', methods: ['POST'])]
    public function changeMember(MemberRepository $memberRepository, Request $request, EntityManagerInterface $em): Response
    {
        $post = json_decode($request->getContent(), true);

        dd($request->getContent());
        $member = $memberRepository->find($post['id']);

        dd($request->getContent());
        return new Response('Image has been udpate');
    }
}
