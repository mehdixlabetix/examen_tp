<?php

namespace App\DataFixtures;
use App\Entity\Etudiant;
use App\Repository\SectionRepository;
use Faker\Factory;
use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtudiantFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create();
        for ($i=0; $i < 5; $i++) {
            $section = new Section();
            $section->setDesignation($faker->word);
            for ($j=0; $j < rand(1, 20); $j++) {
                $etudiant = new Etudiant();
                $etudiant->setNom($faker->lastName);
                $etudiant->setPrenom($faker->firstName);
                $section->addEtudiant($etudiant);
                $etudiant->setAppartient($section);
                $manager->persist($etudiant);
            }
            $manager->persist($section);
        }

        for ($i=0; $i < 15; $i++) {
            $etudiant = new Etudiant();
            $etudiant->setNom($faker->lastName);
            $etudiant->setPrenom($faker->firstName);
            $manager->persist($etudiant);
        }
        $manager->flush();
    }
}
