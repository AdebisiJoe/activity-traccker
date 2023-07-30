<?php

namespace App\DataFixtures;

use App\Entity\UserActivity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserActivityFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Load references to users and activities fixtures
        $users = $manager->getRepository(User::class)->findAll();
        $activities = $manager->getRepository(Activity::class)->findAll();

         // Create UserActivity fixtures
        for ($i = 1; $i <= 5; $i++) {
            $userActivity = new UserActivity();

            // Randomly associate a user and an activity
            $userActivity->setUser($faker->randomElement($users));
            $userActivity->setActivity($faker->randomElement($activities));

            // Generate a random date for the user-specific activity
            $userActivity->setDate($faker->dateTimeBetween('-1 month', '+1 month'));

            $manager->persist($userActivity);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ActivityFixtures::class,
        ];
    }
}
