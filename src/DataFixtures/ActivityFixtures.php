<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Activity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class ActivityFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $userRepository = $manager->getRepository(User::class);


        $users = $manager->getRepository(User::class)->findAll();

        $superAdminUser = '';
        $normalUsers = [];
        foreach ($users as $user) {
            if (in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
                $superAdminUser = $user;
            }

            if (in_array('ROLE_USER', $user->getRoles())) {
                $normalUsers[] = $user;
            }
        }

        foreach ($normalUsers as $user) {
            $image = "https://picsum.photos/1200/350?random=".mt_rand(1, 55000);
            $globalActivity = new Activity();
            $globalActivity->setTitle($faker->sentence(3));
            $globalActivity->setDescription($faker->paragraph());
            $globalActivity->setImage($image);
            $globalActivity->setUserId($superAdminUser);
            $globalActivity->setIsGlobal(true);
            $globalActivity->setParentId(null);
            $globalActivity->setDate($faker->dateTimeBetween('-1 month', '+1 month'));

            $manager->persist($globalActivity);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}