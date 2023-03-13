<?php


namespace App\Service;

use App\Entity\Newsletter;
use App\Entity\Offer\Offer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer{

    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function offerUpdate(Newsletter $subscriber, Offer $offer){
        $email = (new Email())
            ->from('noreply@lycceestvincent.fr')
            ->to($subscriber->getEmail())
            ->subject('Une offre à été mise à jour')
            ->text('Sending emails is fun again!');

        $this->mailer->send($email);
    }

    public function offerCreate(Newsletter $subscriber, Offer $offer){
        $email = (new Email())
            ->from('noreply@lycceestvincent.fr')
            ->to($subscriber->getEmail())
            ->subject('Une nouvelle offre à été créer')
            ->text('Sending emails is fun again!');

        $this->mailer->send($email);
    }
}