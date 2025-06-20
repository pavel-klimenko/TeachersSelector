<?php

namespace App\DataFixtures;

use App\Domain\Entity\City;
use App\Domain\Entity\Country;
use App\Domain\Entity\Expertise;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        //TODO clen architecture and ValueObject, Factories
        $expertise = new Expertise();

        $expertise->setName('Math')
            ->setCode('math');
        $manager->persist($expertise);
        $manager->flush();
    }
}
