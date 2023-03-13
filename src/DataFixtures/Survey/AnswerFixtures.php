<?php

namespace App\DataFixtures\Survey;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Survey\Answer;
use Faker;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $answer = new Answer();
            $answer->setText($faker->word());
            $answer->setAnswerNumber($faker->numberBetween(0, 100));
            $answer->setSurveyId($this->getReference('survey-' . $faker->numberBetween(1, 5)));
            $manager->persist($answer);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SurveyFixtures::class,
        ];
    }
}
