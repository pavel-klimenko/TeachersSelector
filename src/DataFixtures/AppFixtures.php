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

        $math = new Expertise();
        $math->setName('Math')->setCode('math');
        $manager->persist($math);
        $manager->flush();

        $english = new Expertise();
        $english->setName('English')->setCode('english');
        $manager->persist($english);
        $manager->flush();

        $compScience = new Expertise();
        $compScience->setName('Computer science')->setCode('computer_science');
        $manager->persist($compScience);
        $manager->flush();

        $phpDevelopment = new Expertise();
        $phpDevelopment->setName('PHP Development')->setCode('php_development');
        $manager->persist($phpDevelopment);
        $manager->flush();
    }
}
