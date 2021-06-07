<?php
/**
 * Przepis controller.
 */
namespace App\Controller;

use App\Entity\Przepis;
use App\Form\PrzepisType;
use App\Repository\PrzepisRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
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

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\PrzepisRepository $przepisRepository Przepis repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="przepis_create",
     * )
     */
    public function create(Request $request, PrzepisRepository $przepisRepository): Response
    {
        $przepis = new Przepis();
        $form = $this->createForm(PrzepisType::class, $przepis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $przepisRepository->save($przepis);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('przepis_index');
        }

        return $this->render(
            'przepis/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Przepis $przepis Przepis entity
     * @param \App\Repository\PrzepisRepository $przepisRepository Przepis repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="przepis_edit",
     * )
     */
    public function edit(Request $request, Przepis $przepis, PrzepisRepository $przepisRepository): Response
    {
        $form = $this->createForm(PrzepisType::class, $przepis, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $przepisRepository->save($przepis);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('przepis_index');
        }

        return $this->render(
            'przepis/edit.html.twig',
            [
                'form' => $form->createView(),
                'przepis' => $przepis,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Przepis $przepis Przepis entity
     * @param \App\Repository\PrzepisRepository $przepisRepository Przepis repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="przepis_delete",
     * )
     */
    public
    function delete(Request $request, Przepis $przepis, PrzepisRepository $przepisRepository): Response
    {

        $form = $this->createForm(FormType::class, $przepis, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $przepisRepository->delete($przepis);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('przepis_index');
        }

        return $this->render(
            'przepis/delete.html.twig',
            [
                'form' => $form->createView(),
                'przepis' => $przepis,
            ]
        );
    }
}
