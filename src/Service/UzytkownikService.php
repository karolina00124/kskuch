<?php

namespace App\Service;

use App\Entity\Uzytkownik;
use App\Repository\KomentarzRepository;
use App\Repository\PrzepisRepository;
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
    private UzytkownikRepository $uzytkownikRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private PaginatorInterface $paginator;

    /** @var PrzepisRepository */
    private PrzepisRepository $przepisRepository;

    /** @var KomentarzRepository */
    private KomentarzRepository $komentarzRepository;

    /**
     * UzytkownikService constructor.
     *
     * @param \App\Repository\UzytkownikRepository    $uzytkownikRepository Uzytkownik repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator            Paginator
     */
    public function __construct(UzytkownikRepository $uzytkownikRepository, PaginatorInterface $paginator, PrzepisRepository $przepisRepository, KomentarzRepository $komentarzRepository)
    {
        $this->uzytkownikRepository = $uzytkownikRepository;
        $this->paginator = $paginator;
        $this->przepisRepository = $przepisRepository;
        $this->komentarzRepository = $komentarzRepository;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->uzytkownikRepository->queryAll(),
            $page,
            UzytkownikRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Delete uzytkownik with coresponding przepisy and komentarze
     *
     * @param \App\Entity\Uzytkownik $uzytkownik Uzytkownik entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Uzytkownik $uzytkownik): void
    {
        $this->przepisRepository->deleteForUzytkownik($uzytkownik);
        $this->komentarzRepository->deleteForUzytkownik($uzytkownik);
        $this->uzytkownikRepository->delete($uzytkownik);
    }

    /**
     * Save uzytkownik.
     *
     * @param \App\Entity\Uzytkownik $uzytkownik       Uzytkownik entity
     * @param string|null            $newPasswordPlain
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Uzytkownik $uzytkownik, string $newPasswordPlain = null)
    {
        $this->uzytkownikRepository->save($uzytkownik);
    }
    /**
     * Save new uzytkownik.
     *
     * @param \App\Entity\Uzytkownik $uzytkownik       Uzytkownik entity
     * @param string|null            $newPasswordPlain
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save_new(Uzytkownik $uzytkownik, string $newPasswordPlain = null)
    {
        $this->uzytkownikRepository->save_new($uzytkownik);
    }

    /**
     * Register uzytkownik.
     *
     * @param array $data
     * @throws \Doctrine\ORM\ORMException
     */
    public function register(array $data): void
    {
        $this->uzytkownikRepository->register($data);
    }
}
