<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Program;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $program = new Program();
        $program->setTitle('Walking dead');
        $program->setPoster('https://fr.web.img3.acsta.net/pictures/21/04/19/14/51/5593951.jpg');
        $program->setSummary('Des zombies envahissent la terre');
        $program->setCategory($this->getReference('category_0'));
        for ($i=0; $i < 5; $i++) {
            $program->addActor($this->getReference('actor_' . $i));
        }
        $manager->persist($program);
        $this->addReference('program_0', $program);


        $program = new Program();
        $program->setTitle('Fear The Walking Dead');
        $program->setPoster('https://fr.web.img6.acsta.net/pictures/20/09/25/11/43/3207723.jpg');
        $program->setSummary('Des zombies envahissent la terre');
        $program->setCategory($this->getReference('category_0'));
        $program->addActor($this->getReference('actor_1'));
        $program->addActor($this->getReference('actor_5'));
        $manager->persist($program);
        $this->addReference('program_1', $program);


        $program = new Program();
        $program->setTitle('Brooklyn Nine-Nine');
        $program->setPoster('https://fr.web.img6.acsta.net/pictures/20/01/10/10/23/0734068.jpg');
        $program->setSummary("Comedy series following the exploits of Det. Jake Peralta and his diverse,
         lovable colleagues as they police the NYPDs 99th Precinct");
        $program->setCategory($this->getReference('category_5'));
        $program->addActor($this->getReference('actor_6'));
        $manager->persist($program);
        $this->addReference('program_2', $program);


        $program = new Program();
        $program->setTitle('The Mandalorian');
        $program->setPoster('https://fr.web.img5.acsta.net/pictures/20/09/16/09/09/4156636.jpg');
        $program->setSummary("The travels of a lone bounty hunter in the outer reaches of the galaxy, 
        far from the authority of the New Republic.");
        $program->setCategory($this->getReference('category_0'));
        $program->addActor($this->getReference('actor_7'));
        $manager->persist($program);
        $this->addReference('program_3', $program);

        $program = new Program();
        $program->setTitle('The Witcher');
        $program->setPoster('https://sm.ign.com/ign_fr/screenshot/default/d-zs52owsauofg7_jtbw.jpg');
        $program->setSummary("Geralt of Rivia, a solitary monster hunter, struggles to find his
         place in a world where people often prove more wicked than beasts.");
        $program->setCategory($this->getReference('category_3'));
        $program->addActor($this->getReference('actor_8'));
        $manager->persist($program);
        $this->addReference('program_4', $program);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          ActorFixtures::class,
          CategoryFixtures::class,
        ];
    }
}
