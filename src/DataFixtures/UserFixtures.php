<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }


    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('demo@exemple.fr');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $user->setPseudo('demo');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $manager->flush();
    }
}
