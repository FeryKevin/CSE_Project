<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Contact;
use Faker;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $contact = new Contact();
            $contact->setName($faker->lastName());
            $contact->setFirstName($faker->firstName());
            $contact->setEmail($faker->email());
            $contact->setMessage($faker->text());
            $manager->persist($contact);
        }

        $manager->flush();
    }
}
