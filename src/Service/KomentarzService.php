<?php

namespace App\Service;

use App\Entity\Komentarz;
use App\Repository\KomentarzRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class KomentarzService
{
    /**
     * Komentarz repository.
     *
     * @var \App\Repository\KomentarzRepository
     */
    private $komentarzRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * KomentarzService constructor.
     *
     * @param \App\Repository\KomentarzRepository      $komentarzRepository Komentarz repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator          Paginator
     */
    public function __construct(KomentarzRepository $komentarzRepository, PaginatorInterface $paginator)
    {
        $this->komentarzRepository = $komentarzRepository;
        $this->paginator = $paginator;
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
            $this->komentarzRepository->queryAll(),
            $page,
            KomentarzRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save komentarz.
     *
     * @param \App\Entity\Komentarz $komentarz Komentarz entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Komentarz $komentarz): void
    {
        $this->komentarzRepository->save($komentarz);
    }

    /**
     * Delete komentarz.
     *
     * @param \App\Entity\Komentarz $komentarz Komentarz entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Komentarz $komentarz): void
    {
        $this->komentarzRepository->delete($komentarz);
    }
}
