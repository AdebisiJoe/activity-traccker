<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Create a super admin user
        $user = new User();
        $user->setEmail('admin@gmail.com');
        $user->setPassword($this->userPasswordHasherInterface->hashPassword(
            $user, "admin_password"
        ));
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($user);

        // Create other users
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($this->userPasswordHasherInterface->hashPassword(
                $user, "password"
            ));
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
