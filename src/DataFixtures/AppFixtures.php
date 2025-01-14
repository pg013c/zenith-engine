<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private array $users = [
        [
            'email' => 'admin@zenith.com',
            'password' => 'admin1',
            'roles' => ['ROLE_ADMIN'],
        ],
        [
            'email' => 'user@zenith.com',
            'password' => 'user1',
            'roles' => ['ROLE_USER'],
        ],
    ];

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->users as $userData) {
            $user = new User();
            $user->setEmail($userData['email']);

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $userData['password']
            );
            $user->setPassword($hashedPassword);
            $user->setRoles($userData['roles']);

            $manager->persist($user);
        }


        $manager->flush();
    }
}
