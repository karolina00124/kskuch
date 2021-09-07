<?php
/**
 * PrzepisService
 */

namespace App\Service;

use App\Entity\Przepis;
use App\Repository\PrzepisRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * PrzepisService class
 */
class PrzepisService
{
    /**
     * Przepis repository.
     */
    private PrzepisRepository $przepisRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * PrzepisService constructor.
     *
     * @param PrzepisRepository  $przepisRepository Przepis repository
     * @param PaginatorInterface $paginator         Paginator
     */
    public function __construct(PrzepisRepository $przepisRepository, PaginatorInterface $paginator)
    {
        $this->przepisRepository = $przepisRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int   $page    Page number
     * @param array $filters Filtry
     *
     * @return PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->przepisRepository->queryAll($filters),
            $page,
            PrzepisRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save przepis.
     *
     * @param Przepis $przepis Przepis entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Przepis $przepis): void
    {
        $this->przepisRepository->save($przepis);
    }

    /**
     * Delete przepis.
     *
     * @param Przepis $przepis Przepis entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Przepis $przepis): void
    {
        $this->przepisRepository->delete($przepis);
    }

    /**
     * @param int $przepisId
     *
     * @return Przepis|null
     */
    public function getOne(int $przepisId): ?Przepis
    {
        return $this->przepisRepository->find($przepisId);
    }

    /**
     * @param Przepis $przepis
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function voteUp(Przepis $przepis)
    {
        $przepis->setThumbUp($przepis->getThumbUp() + 1);
        $this->save($przepis);
    }

    /**
     * @param Przepis $przepis
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function voteDown(Przepis $przepis)
    {
        $przepis->setThumbDown($przepis->getThumbDown() + 1);
        $this->save($przepis);
    }
}
