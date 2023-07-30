<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Activity;
use Faker\Factory;


class ActivityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            $activity = new Activity();
            $activity->setTitle($faker->sentence(3));
            $activity->setDescription($faker->paragraph());
            $activity->setImage($faker->image());
            $activity->setDate($faker->dateTimeBetween('-1 month', '+1 month'));

            $manager->persist($activity);
        }

        $manager->flush();
    }
}