<?php

namespace App\DataFixtures;

use App\Entity\TypeDeReduction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeDeReductionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $typeDeReduction = new TypeDeReduction();
        $typeDeReduction->setLabel('Pourcentage');

        $typeDeReduction2 = new TypeDeReduction();
        $typeDeReduction2->setLabel('Euro');

        $typeDeReduction3 = new TypeDeReduction();
        $typeDeReduction3->setLabel('Livraison gratuite');

        $manager->persist($typeDeReduction);
        $manager->persist($typeDeReduction2);
        $manager->persist($typeDeReduction3);

        $manager->flush();
    }
}
