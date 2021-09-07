<?php
/**
 * KomentarzService
 */

namespace App\Service;

use App\Entity\Komentarz;
use App\Repository\KomentarzRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * KomentarzService class
 */
class KomentarzService
{
    /**
     * Komentarz repository.
     */
    private KomentarzRepository $komentarzRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * KomentarzService constructor.
     *
     * @param KomentarzRepository $komentarzRepository Komentarz repository
     * @param PaginatorInterface  $paginator           Paginator
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
     * @return PaginationInterface Paginated list
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
     * @param Komentarz $komentarz Komentarz entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Komentarz $komentarz): void
    {
        $this->komentarzRepository->save($komentarz);
    }

    /**
     * Delete komentarz.
     *
     * @param Komentarz $komentarz Komentarz entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Komentarz $komentarz): void
    {
        $this->komentarzRepository->delete($komentarz);
    }
}
