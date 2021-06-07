<?php
/**
 * Tag fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TagFixtures.
 */
class TagFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; ++$i) {
            $tag = new Tag();
            $tag->setTagNazwa($this->faker->word);
            $tag->setDataUtworzenia($this->faker->dateTimeBetween('-100 days', '-1 days'));

            $this->manager->persist($tag);
        }

        $manager->flush();
    }
}