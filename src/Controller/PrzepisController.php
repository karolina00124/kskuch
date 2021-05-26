<?php

namespace App\Controller;

use App\Entity\Przepis;
use App\Repository\PrzepisRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PrzepisController.
 * @Route("/przepis")
 */
class PrzepisController extends AbstractController
{
    /**
     * Przepis Repository.
     *
     * @var \App\Repository\PrzepisRepository
     */
    private PrzepisRepository $przepisRepository;

    private PaginatorInterface $paginator;

    /**
     * PrzepisController constructor.
     *
     * @param \App\Repository\PrzepisRepository $przepisRepository Przepis repository
     */
    public function __construct(PrzepisRepository $przepisRepository, PaginatorInterface $paginator)
    {
        $this->przepisRepository = $przepisRepository;
        $this->paginator = $paginator;
    }

    /**
     * Index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="przepis_index",
     * )
     */
    public function index(Request $request): Response
    {
        $filters = [];
        $filters['kategoria_id'] = $request->query->getInt('filters_kategoria_id');

        $pagination = $this->paginator->paginate(
            $this->przepisRepository->queryAll($filters),
            $request->query->getInt('page', 1),
            PrzepisRepository::PAGINATOR_ITEMS_PER_PAGE,
        );

        return $this->render(
            'przepis/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Przepis $przepis Przepis entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="przepis_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Przepis $przepis): Response
    {
        return $this->render(
            'przepis/show.html.twig',
            ['przepis' => $przepis]
        );
    }
}
