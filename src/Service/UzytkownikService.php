<?php
/**
 * UzytkownikService
 */

namespace App\Service;

use App\Entity\Uzytkownik;
use App\Repository\KomentarzRepository;
use App\Repository\PrzepisRepository;
use App\Repository\UzytkownikRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * UzytkownikService class
 */
class UzytkownikService
{
    /**
     * Uzytkownik repository.
     */
    private UzytkownikRepository $uzytkownikRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    private PrzepisRepository $przepisRepository;

    private KomentarzRepository $komentarzRepository;

    /**
     * UzytkownikService constructor.
     *
     * @param UzytkownikRepository $uzytkownikRepository Uzytkownik repository
     * @param PaginatorInterface   $paginator            Paginator
     * @param PrzepisRepository    $przepisRepository
     * @param KomentarzRepository  $komentarzRepository
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
     * @return PaginationInterface Paginated list
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
     * Delete uzytkownik with coresponding przepisy and komentarze.
     *
     * @param Uzytkownik $uzytkownik Uzytkownik entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
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
     * @param Uzytkownik  $uzytkownik       Uzytkownik entity
     * @param string|null $newPasswordPlain
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Uzytkownik $uzytkownik, string $newPasswordPlain = null)
    {
        $this->uzytkownikRepository->save($uzytkownik, $newPasswordPlain);
    }

    /**
     * Register uzytkownik.
     *
     * @param array $data
     *
     * @throws ORMException
     */
    public function register(array $data): void
    {
        $this->uzytkownikRepository->register($data);
    }
}
