<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Partner;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class PartnerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('en_US');
        for ($i = 0; $i < 10; $i++) {
            $partner = new Partner();
            $partner->setImage($this->getReference('partner-'.$i))
                ->setName($faker->company())
                ->setDescription($faker->sentence())
                ->setWebsiteLink($faker->safeEmailDomain());
            $manager->persist($partner);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            FileFixtures::class,
        ];
    }
}
