<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Actor;

class ActorFixtures extends Fixture
{
    public const ACTORS_WALKING = [
        'Norman Reedus',
        'Andrew Lincoln',
        'Lauren Cohan',
        'Jeffrey Dean Morgan',
        'Chandler Riggs',
        'Kim Dickens',
        'Andy Samberg',
        'Pedro Pascal',
        'Henry Cavill',
    ];


    public function load(ObjectManager $manager)
    {
        foreach (self::ACTORS_WALKING as $key => $actorName) {
            $actor = new Actor();
            $actor->setName($actorName);
            $manager->persist($actor);
            $this->addReference('actor_' . $key, $actor);
        }
        $manager->flush();
    }
}
