<?php


namespace App\Service;

use App\Repository\NewsletterRepository;
use App\Entity\Offer;

class Newsletter{

    private const SLEEP_TIME = 1;
    private NewsletterRepository $newsletterRepository;
    private Mailer $mailer;

    public function __construct(NewsletterRepository $newsletterRepository, Mailer $mailer)
    {
        $this->newsletterRepository = $newsletterRepository;
        $this->mailer = $mailer;
    }

    public function sendUpdateOffer(Offer $offer){
        foreach ($this->newsletterRepository->findAll() as $subscriber){
            $this->mailer->offerUpdate($subscriber, $offer);
            sleep(self::SLEEP_TIME);
        }
    }

    public function sendNewOffer(Offer $offer){
        foreach ($this->newsletterRepository->findAll() as $subscriber){
            $this->mailer->offerCreate($subscriber, $offer);
            sleep(self::SLEEP_TIME);
        }
    }
}
