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
        $cse = new CSE();
        $cse->setPresentationHome($faker->text())
            ->setPresentationAbout($faker->text())
            ->setRules($faker->text())
            ->setEmail($faker->email())
            ->setActions($faker->text());
        $manager->persist($cse);

        $manager->flush();
    }
}
