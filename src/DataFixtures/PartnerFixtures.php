<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Partner;
use Faker;

class PartnerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('en_US');
        for ($i = 0; $i < 20; $i++) {
            $partner = new Partner();
            $partner->setImage($faker->imageUrl(640, 480, 'company', true));
            $partner->setName($faker->company());
            $partner->setDescription($faker->sentence());
            $partner->setWebsiteLink($faker->safeEmailDomain());
            $manager->persist($partner);
        }

        $manager->flush();
    }
}
