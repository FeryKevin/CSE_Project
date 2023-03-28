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
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail($faker->email())
                ->setPassword($this->encoder->hashPassword($user, $faker->password()))
                ->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }

        $user = new User();
        $user->setEmail('e@e.e')
            ->setPassword('$argon2i$v=19$m=65536,t=4,p=1$a3Z0enFWN1lCa3M4ZDAwTw$k5q0xgFmu+Di5s8GE4yT/8FTSx0EW9jLX9IFjaGVup8')
            ->setRoles(['ROLE_ADMIN']);

        $manager->flush();
    }
}
