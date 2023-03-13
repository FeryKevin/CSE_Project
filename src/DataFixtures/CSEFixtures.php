<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\CSE;
use Faker;

class CSEFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 2; $i++) {
            $cse = new CSE();
            $cse->setPresentationHome($faker->text());
            $cse->setPresentationAbout($faker->text());
            $cse->setRules($faker->text());
            $cse->setEmail($faker->email());
            $cse->setActions($faker->text());
            $manager->persist($cse);
        }

        $manager->flush();
    }
}
