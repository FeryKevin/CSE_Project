<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\File;
use Faker;

class FileFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        if (!is_dir('public/img/offer')) mkdir('public/img/offer');

        for ($i = 0; $i < 10; $i++) {
            $file = FILE::createFromPath($faker->image('public/img/offer', 640, 480, 'company', true, true, 'partner'));
            $file->setOriginalName($faker->word());
            $this->addReference('partner-'.$i, $file);
            $manager->persist($file);
        }

        for ($i = 0; $i < 50; $i++) {
            $file = FILE::createFromPath($faker->image('public/img/offer', 640, 480, 'placeholder', true, true, 'offer'));
            $file->setOriginalName($faker->word());
            $this->addReference('offer-'.$i, $file);
            $manager->persist($file);
        }

        $manager->flush();
    }
}
