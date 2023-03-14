<?php


namespace App\Service;

use App\Entity\Newsletter;
use App\Entity\Offer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\File;
use Symfony\Component\Mime\Part\DataPart;

class Mailer
{
    private MailerInterface $mailer;

    private const SENDER = "noreply@lyceestvincent.fr";

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function offerUpdate(Newsletter $subscriber, Offer $offer)
    {
        $email = (new Email())
            ->from(self::SENDER)
            ->to($subscriber->getEmail())
            ->subject('Une offre à été mise à jour')
            ->html("<h2>Une offre à été mise à jour</h2>
                <h1>{$offer->getName()}: </h1>
                <p>{$offer->getDescription()}</p>                
                <a href='http://localhost:8000/'> -> En profiter <- </a>")
            ->addPart((new DataPart(new File('../' . $offer->getImages()[0]->getPath(), 'offer-image', 'image/png')))->asInline());

        $this->mailer->send($email);
    }

    public function offerCreate(Newsletter $subscriber, Offer $offer)
    {
        $email = (new Email())
            ->from(self::SENDER)
            ->to($subscriber->getEmail())
            ->subject('Une nouvelle offre à été créée')
            ->html("<h2>Une nouvelle offre à été ajoutée</h2>
            <h1>{$offer->getName()}</h1>
            <p>{$offer->getDescription()}</p>
            <a href=http://localhost:8000/> -> En profiter <- </a>")
            ->addPart((new DataPart(new File('../' . $offer->getImages()[0]->getPath(), 'offer-image', 'image/png')))->asInline());

        $this->mailer->send($email);
    }
}
