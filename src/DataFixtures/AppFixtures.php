<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $nasa = new Entreprise();
        $nasa->setNom("NASA");
        $nasa->setAdresse("3 rue des potiers");
        $nasa->setMilieu("AeroSpacial");

        $manager->persist($nasa);
        $manager->flush();
    }
}
