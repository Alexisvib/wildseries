<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
      'Action',
      'Aventure',
      'Animation',
      'Fantastique',
      'Horreur',
      'Comique',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $this->addReference('category_' . $key, $category);
        }
        $manager->flush();
    }
}
