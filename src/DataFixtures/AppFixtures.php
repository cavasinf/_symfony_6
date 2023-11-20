<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Organisation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 5; $i++) {
            $faker = Factory::create();

            $organisation = (new Organisation())
                ->setName($faker->company)
            ;

            $manager->persist($organisation);
        }

        for ($i = 1; $i < 15; $i++) {
            $faker = Factory::create();

            $client = (new Client())
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setAge(\random_int(15, 99))
            ;

            $manager->persist($client);
        }

        $manager->flush();
    }
}
