<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use App\Entity\User;
use Faker;

class UserFixtures extends Fixture
{

    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->encoder = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i = 0; $i < 20; $i++){
            $user = new User();
            $user->setEmail($faker->email());
            $user->setPassword($this->encoder->hashPassword($user, ($faker->password())));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
