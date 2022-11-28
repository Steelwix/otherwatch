<?php

namespace App\DataFixtures;

use App\Entity\Heroes;
use App\Entity\Roles;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HeroesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $roles = new Roles;
        $roles->setName("Role");
        $manager->persist($roles);

        $heroes2 = new Heroes;
        $heroes2->setRole($roles);
        $heroes2->setName("Zariou");
        $heroes2->setCreationDate(new DateTime);
        $heroes2->setSlug("zariou");

        $heroes3 = new Heroes;
        $heroes3->setRole($roles);
        $heroes3->setName("winou");
        $heroes3->setCreationDate(new DateTime);
        $heroes3->setSlug("winou");

        $heroes1 = new Heroes;
        $heroes1->setRole($roles);
        $heroes1->setName("riou");
        $heroes1->setCreationDate(new DateTime);
        $heroes1->setSlug("riou");
        $heroes1->addCounter($heroes2);
        $heroes1->addCounter($heroes3);
        $manager->persist($heroes1);
        $manager->persist($heroes2);
        $manager->persist($heroes3);


        $manager->flush();
    }
}
