<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Newsletter;
use Faker;

class NewsletterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i = 0; $i < 20; $i++){
            $newsletter = new Newsletter();
            $newsletter->setEmail($faker->email());
            $manager->persist($newsletter);
        }

        $manager->flush();
    }
}
