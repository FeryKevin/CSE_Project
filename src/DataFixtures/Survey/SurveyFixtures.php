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
        for ($i = 0; $i <= 5; $i++) {
            $survey = new Survey();
            $survey->setActive($faker->boolean());
            $survey->setQuestion(str_replace('.', '?', $faker->sentence()));
            $this->addReference('survey-' . $i + 1, $survey);
            $manager->persist($survey);
        }

        $manager->flush();
    }
}
