<?php

namespace App\DataFixtures\Survey;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Answer;
use Faker;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i <= 5; $i++) {
            $survey = $this->getReference('survey' . $i);
            for ($j = 0; $j < $faker->numberBetween(2, 4); $j++) {
                $answer = new Answer();
                $answer->setText($faker->word());
                $answer->setAnswerNumber($faker->numberBetween(0, 100));

                $survey->addAnswer($answer);
                $manager->persist($answer);
            }
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
