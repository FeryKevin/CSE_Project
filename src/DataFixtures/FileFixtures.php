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
        if (!is_dir('public/img/partner')) mkdir('public/img/partner');
        if (!is_dir('public/img/member')) mkdir('public/img/member');

        for ($i = 0; $i < 50; $i++) {
            $file = FILE::createFromPath($faker->image('public/img/offer', 640, 480, 'placeholder', true, true, 'offer'), "offer");
            $file->setOriginalName($faker->word());
            $this->addReference('offer-' . $i, $file);
            $manager->persist($file);
        }

        for ($i = 0; $i < 5; $i++) {
            $file = FILE::createFromPath($faker->image('public/img/member', 640, 480, 'member', true, true, 'member'), "member");
            $file->setOriginalName($faker->word());
            $this->addReference('member-' . $i, $file);
            $manager->persist($file);
        }

        for ($i = 0; $i < 10; $i++) {
            $file = FILE::createFromPath($faker->image('public/img/partner', 640, 480, 'company', true, true, 'partner'), "partner");
            $file->setOriginalName($faker->word());
            $this->addReference('partner-' . $i, $file);
            $manager->persist($file);
        }

        $manager->flush();
    }
}
