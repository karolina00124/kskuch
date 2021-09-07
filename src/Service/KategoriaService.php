<?php
/**
 * KategoriaService
 */

namespace App\Service;

use App\Entity\Kategoria;
use App\Repository\KategoriaRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * KategoriaService class
 */
class KategoriaService
{
    /**
     * Kategoria repository.
     */
    private KategoriaRepository $kategoriaRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * KategoriaService constructor.
     *
     * @param KategoriaRepository $kategoriaRepository Kategoria repository
     * @param PaginatorInterface  $paginator           Paginator
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
     * @return PaginationInterface Paginated list
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
     * @param Kategoria $kategoria Kategoria entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Kategoria $kategoria): void
    {
        $this->kategoriaRepository->save($kategoria);
    }

    /**
     * Delete kategoria.
     *
     * @param Kategoria $kategoria Kategoria entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Kategoria $kategoria): void
    {
        $this->kategoriaRepository->delete($kategoria);
    }
}
