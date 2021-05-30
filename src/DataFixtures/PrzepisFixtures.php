<?php
/**
 * Przepis fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Przepis;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TaskFixtures.
 */
class PrzepisFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        for ($i = 0; $i < 25; ++$i) {
            $przepis = new Przepis();
            $przepis->setNazwa($this->faker->sentence(5));
            $przepis->setDataUtworzenia($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $przepis->setInfo($this->faker->sentence);
            $przepis->setKroki($this->faker->sentence);
            $przepis->setSkladniki($this->faker->sentence);

            $this->manager->persist($przepis);
        }

        $manager->flush();
    }
}