<?php

namespace App\Service;

use App\Entity\Uzytkownik;
use App\Repository\UzytkownikRepository;

class UzytkownikService
{
    /**
     * Uzytkownik repository.
     *
     * @var \App\Repository\UzytkownikRepository
     */
    private $uzytkownikRepository;

    /**
     * UzytkownikService constructor.
     *
     * @param \App\Repository\UzytkownikRepository      $uzytkownikRepository Uzytkownik repository
     */
    public function __construct(UzytkownikRepository $uzytkownikRepository)
    {
        $this->uzytkownikRepository = $uzytkownikRepository;
    }

    /**
     * Save uzytkownik.
     *
     * @param \App\Entity\Uzytkownik $uzytkownik Uzytkownik entity
     * @param string|null $newPasswordPlain
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Uzytkownik $uzytkownik, string $newPasswordPlain = null)
    {
        $this->uzytkownikRepository->save($uzytkownik);
    }

    /**
     * Register uzytkownik.
     *
     * @param array $data
     */
    public function register(array $data): void
    {
        $this->uzytkownikRepository->register($data);
    }
}
