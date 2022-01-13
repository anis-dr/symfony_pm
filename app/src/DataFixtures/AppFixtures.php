<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Create an admin account
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);
        $user->setIsVerified(true);
        $user->setEmail('admin@admin.me');
        $user->setPassword($this->hasher->hashPassword($user, 'admin'));
        $manager->persist($user);

        $manager->flush();
    }
}
