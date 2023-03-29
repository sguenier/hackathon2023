<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $job = new Job();
        $job->setName("CEO");
        $job->setIntern(true);
        $manager->persist($job);

        $job = new Job();
        $job->setName("Responsable RH");
        $job->setIntern(true);
        $manager->persist($job);

        $job = new Job();
        $job->setName("Clown");
        $job->setIntern(false);
        $manager->persist($job);

        $job = new Job();
        $job->setName("Buraliste");
        $job->setIntern(false);
        $manager->persist($job);

        $job = new Job();
        $job->setName("Equipier polyvalent");
        $job->setIntern(false);
        $manager->persist($job);

        $manager->flush();

    }

}