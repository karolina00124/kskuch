<?php

namespace App\DataFixtures;

use App\Entity\Kategoria;
use App\Entity\Przepis;
use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends AbstractBaseFixtures
{
    protected function loadData(ObjectManager $manager): void
    {
        $kategorie = $this->loadKategorie($manager);
        $tags = $this->loadTags($manager);
        $this->loadPrzepis($manager, $tags, $kategorie);

        $manager->flush();
    }

    private function loadKategorie($manager) : array
    {
        $kategorie = [];
        $nazwy = [
            'Biszkopty',
            'Kremy i tynki',
            'Dekoracje',
            'Wkłady',
        ];
        $i = 0;
        foreach ($nazwy as $nazwa) {
            $kategorie[$i] = new Kategoria();
            $kategorie[$i]->setKategoriaNazwa($nazwa);
            $this->manager->persist($kategorie[$i]);
            $i++;
        }

        $manager->flush();
        return $kategorie;
    }

    private function loadTags(ObjectManager $manager)
    {
        $tags = [];

        for ($i = 0; $i < 20; ++$i) {
            $tags[$i] = new Tag();
            $tags[$i]->setTagNazwa($this->faker->word);
            $tags[$i]->setDataUtworzenia($this->faker->dateTimeBetween('-100 days', '-1 days'));

            $this->manager->persist($tags[$i]);
        }

        $manager->flush();

        return $tags;
    }

    private function loadPrzepis(ObjectManager $manager, array $tags, array $kategorie)
    {
        for ($i = 0; $i < 25; ++$i) {
            $przepis = new Przepis();
            $przepis->setNazwa($this->faker->sentence(5));
            $przepis->setDataUtworzenia($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $przepis->setInfo($this->faker->sentence);
            $przepis->setKroki($this->faker->sentence);
            $przepis->setSkladniki($this->faker->sentence);
            $przepis->setKategoria($kategorie[0]);

            $randomsTagNumber = rand(0, 3);
            if($randomsTagNumber > 0) {
                $randomTagsIndex = (array)array_rand($tags, $randomsTagNumber);
                foreach ($randomTagsIndex as $randomTagIndex) {
                    $przepis->addTag($tags[$randomTagIndex]);
                }
            }
                $randomsKategoriaNumber = rand(0, 3);
                if($randomsKategoriaNumber >= 0) {
                    $randomKategorieIndex = (array) array_rand($kategorie, $randomsKategoriaNumber);
                    foreach ($randomKategorieIndex as $randomKategoriaIndex) {
                        $przepis->addKategoria($kategorie[$randomKategoriaIndex]);
                    }
            }

            $this->manager->persist($przepis);
        }

        $manager->flush();
    }

}
