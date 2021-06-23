<?php
namespace App\Service;

use App\Entity\Uzytkownik;
use App\Repository\UzytkownikRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;


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
     * @param \Knp\Component\Pager\PaginatorInterface $paginator          Paginator
     */
    public function __construct(UzytkownikRepository $uzytkownikRepository, PaginatorInterface $paginator)
    {
        $this->uzytkownikRepository = $uzytkownikRepository;
        $this->paginator = $paginator;
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
     * @param $data
     */
    public function register($data): void
    {
        $this->uzytkownikRepository->register($data);
    }
}
