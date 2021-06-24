<?php

namespace App\Service;

use App\Entity\Kategoria;
use App\Repository\KategoriaRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class KategoriaService
{
    /**
     * Kategoria repository.
     *
     * @var \App\Repository\KategoriaRepository
     */
    private KategoriaRepository $kategoriaRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private PaginatorInterface $paginator;

    /**
     * KategoriaService constructor.
     *
     * @param \App\Repository\KategoriaRepository     $kategoriaRepository Kategoria repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator           Paginator
     */
    public function __construct(KategoriaRepository $kategoriaRepository, PaginatorInterface $paginator)
    {
        $this->kategoriaRepository = $kategoriaRepository;
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
            $this->kategoriaRepository->queryAll(),
            $page,
            KategoriaRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save kategoria.
     *
     * @param \App\Entity\Kategoria $kategoria Kategoria entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Kategoria $kategoria): void
    {
        $this->kategoriaRepository->save($kategoria);
    }

    /**
     * Delete kategoria.
     *
     * @param \App\Entity\Kategoria $kategoria Kategoria entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Kategoria $kategoria): void
    {
        $this->kategoriaRepository->delete($kategoria);
    }
}
