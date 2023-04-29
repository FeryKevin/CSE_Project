<?php

namespace App\DataFixtures\Survey;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Survey;
use Faker;

class SurveyFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $isActive = false;

        for ($i = 0; $i <= 5; $i++) {
            $survey = new Survey();
            if (!$isActive) {
                $survey->setActive(1);
                $isActive = !$isActive;
            } else {
                $survey->setActive(0);
            }

            $survey->setQuestion(str_replace('.', '?', $faker->sentence()));

            $this->addReference('survey' . $i, $survey);
            $manager->persist($survey);
        }

        $manager->flush();
    }
}
