<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Member;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class MemberFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 5; $i++) {
            $member = new Member();
            $member->setImage($this->getReference('member-' . $i))
                ->setName($faker->name())
                ->setFirsname($faker->firstName());
            $manager->persist($member);
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
