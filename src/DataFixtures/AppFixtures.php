<?php
/**
 * AppFixtures.
 */

namespace App\DataFixtures;

use App\Entity\Kategoria;
use App\Entity\Komentarz;
use App\Entity\Przepis;
use App\Entity\Tag;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 *
 */
class AppFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @psalm-return array<class-string<FixtureInterface>>
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

    /**
     * @param ObjectManager $manager
     *
     * @param array         $przepisy
     */
    public function loadKomentarze(ObjectManager $manager, array $przepisy)
    {
        foreach ($przepisy as $przepis) {
            for ($i = 0; $i < 3; ++$i) {
                $komentarz = new Komentarz();
                $komentarz->setTresc($this->faker->sentence);
                $komentarz->setPrzepis($przepis);
                $komentarz->setAutor($this->getReference(UserFixtures::ADMIN_REFERENCE));
                $this->manager->persist($komentarz);
            }

            for ($i = 0; $i < 3; ++$i) {
                $komentarz = new Komentarz();
                $komentarz->setTresc($this->faker->sentence);
                $komentarz->setPrzepis($przepis);
                $komentarz->setAutor($this->getReference(UserFixtures::USER_REFERENCE));
                $this->manager->persist($komentarz);
            }

            $manager->flush();
        }
    }

    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    protected function loadData(ObjectManager $manager): void
    {
        $kategorie = $this->loadKategorie($manager);
        $tags = $this->loadTags($manager);
        $przepisy = $this->loadPrzepis($manager, $tags, $kategorie);
        $this->loadKomentarze($manager, $przepisy);

        $manager->flush();
    }

    /**
     * @param $manager
     *
     * @return Kategoria[]
     */
    private function loadKategorie($manager): array
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
            ++$i;
        }

        $manager->flush();

        return $kategorie;
    }

    /**
     * @param ObjectManager $manager
     *
     * @return array
     */
    private function loadTags(ObjectManager $manager): array
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

    /**
     * @param ObjectManager $manager
     *
     * @param array         $tags
     * @param array         $kategorie
     *
     * @return array
     */
    private function loadPrzepis(ObjectManager $manager, array $tags, array $kategorie): array
    {
        $przepisy = [];
        for ($i = 0; $i < 25; ++$i) {
            $przepis = new Przepis();
            $przepis->setNazwa($this->faker->word());
            $przepis->setDataUtworzenia($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $przepis->setInfo($this->faker->sentence);
            $przepis->setKroki($this->faker->sentence);
            $przepis->setSkladniki($this->faker->sentence);
            $przepis->setAuthor($this->getReference(UserFixtures::USER_REFERENCE));

            // losujemy index z tablicy
            $randomKategoriaIndex = (array) array_rand($kategorie);
            // przypisujemy kategorie o losowym indeksie
            $przepis->setKategoria($kategorie[$randomKategoriaIndex[0]]);

            $randomsTagNumber = rand(0, 3);
            if ($randomsTagNumber > 0) {
                $randomTagsIndex = (array) array_rand($tags, $randomsTagNumber);
                foreach ($randomTagsIndex as $randomTagIndex) {
                    $przepis->addTag($tags[$randomTagIndex]);
                }
            }

            $this->manager->persist($przepis);
            $przepisy[] = $przepis;
        }

        $manager->flush();

        return $przepisy;
    }
}
