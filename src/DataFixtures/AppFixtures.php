<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Place;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $user = new User();
        $user->setEmail('matthieu@boxydev.com');
        $user->setPassword($this->hasher->hashPassword($user, 'password'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('toto@boxydev.com');
        $user->setPassword($this->hasher->hashPassword($user, 'password'));
        $manager->persist($user);

        for ($i = 1; $i <= 10; $i++) {
            $place = new Place();
            $place->setName($faker->city());
            $place->setAddress($faker->streetAddress());
            $place->setZipCode($faker->postcode());
            $place->setCity($faker->city());
            $place->setCountry($faker->country());
            $manager->persist($place);
        }

        for ($i = 1; $i <= 10; $i++) {
            $category = new Category();
            $category->setName($faker->word());
            $manager->persist($category);
        }

        for ($i = 1; $i <= 10; $i++) {
            $event = new Event();
            $event->setName('Concert '.$i);
            $event->setDescription('Lorem ipsum');
            $event->setPrice($faker->numberBetween(10, 100));
            $event->setStartAt(
                $d = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days'))
            );
            $event->setEndAt($d->modify('+2 days'));
            $event->setPlace($place);
            $event->addCategory($category);
            $manager->persist($event);
        }

        $manager->flush();
    }
}
