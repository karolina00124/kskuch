<?php


namespace App\Service;

use App\Entity\Przepis;
use App\Repository\PrzepisRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class PrzepisService
{
    /**
     * Przepis repository.
     *
     * @var \App\Repository\PrzepisRepository
     */
    private PrzepisRepository $przepisRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private PaginatorInterface $paginator;

    /**
     * PrzepisService constructor.
     *
     * @param \App\Repository\PrzepisRepository       $przepisRepository Przepis repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator         Paginator
     */
    public function __construct(PrzepisRepository $przepisRepository, PaginatorInterface $paginator)
    {
        $this->przepisRepository = $przepisRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     * @param array $filters Filtry
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
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
     * @param \App\Entity\Przepis $przepis Przepis entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Przepis $przepis): void
    {
        $this->przepisRepository->save($przepis);
    }

    /**
     * Delete przepis.
     *
     * @param \App\Entity\Przepis $przepis Przepis entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
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
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function voteUp(Przepis $przepis)
    {
        $przepis->setThumbUp($przepis->getThumbUp() + 1);
        $this->save($przepis);
    }

    /**
     * @param Przepis $przepis
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function voteDown(Przepis $przepis)
    {
        $przepis->setThumbDown($przepis->getThumbDown() + 1);
        $this->save($przepis);
    }
}
