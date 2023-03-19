<?php

namespace App\Controller;

use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private OfferRepository $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    #[Route(path: '/', name: 'home'), Route(path: '/{page}', name: 'paginedHome')]
    public function home(int $page = 1): Response
    {
        $pagination = $this->offerRepository->findWithPaginator($page);

        return $this->render(
            'index.html.twig',
            [
                'pagination' => $pagination,
            ]
        );
    }
}
