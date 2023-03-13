<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Offer;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class OfferFixtures extends Fixture implements DependentFixtureInterface
{

    private const TYPES = ['limited', 'permanent'];

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $cpt = 0;

        for ($i = 0; $i < 11; $i++) {
            $type = $faker->randomElement(self::TYPES);
            $publish = $faker->dateTime();
            $offer = new Offer();
            $offer->setPublishedAt($publish)
                ->setDescription($faker->text())
                ->setType($type);

            if ($type === 'limited'){
                $offer->setLimitedDisplayBeginning($faker->dateTime())
                    ->setLimitedDisplayEnding($publish->modify("+{$faker->randomDigitNotZero()} days"))
                    ->setLimitedDisplayNumber($faker->randomNumber(5, false));
            } else {
                $validate = $faker->dateTime();
                $offer->setPermanentMinimumPlaces($faker->randomNumber(2, false))
                    ->setPermanentName($faker->word())
                    ->setPermanentValidityBeginning($validate)
                    ->setPermanentValidityEnding($validate->modify("+{$faker->randomDigitNotZero()} days"));
            }

            for ($_ = $faker->numberBetween(0, 3); $_ < 4; $_++){
                $offer->addImage($this->getReference("offer-{$cpt}"));
                $cpt++;
            }

            $manager->persist($offer);
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
