<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Season;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $season = new Season();
        $season->setNumber(1);
        $season->setDescription('Saison 1 de Brooklyn Nine-Nine.');
        $season->setYear(2013);
        $season->setProgram($this->getReference('program_2'));
        $manager->persist($season);
        $this->addReference('season_0', $season);

        $season = new Season();
        $season->setNumber(2);
        $season->setDescription('Saison 2 de Brooklyn Nine-Nine.');
        $season->setYear(2014);
        $season->setProgram($this->getReference('program_2'));
        $manager->persist($season);
        $this->addReference('season_1', $season);

        $season = new Season();
        $season->setNumber(3);
        $season->setDescription('Saison 3 de Brooklyn Nine-Nine.');
        $season->setYear(2015);
        $season->setProgram($this->getReference('program_2'));
        $manager->persist($season);
        $this->addReference('season_2', $season);

        $manager->flush();
    }

    public function getDependencies()
    {
       return [
         ProgramFixtures::class,
       ];
    }
}
