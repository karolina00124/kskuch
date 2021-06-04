<?php
/**
 * Kategoria controller.
 */

namespace App\Controller;

use App\Entity\Kategoria;
use App\Form\KategoriaType;
use App\Repository\KategoriaRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class KategoriaController.
 *
 * @Route("/kategoria")
 */
class KategoriaController extends AbstractController
{
    private KategoriaRepository $kategoriaRepository;

    private PaginatorInterface $paginator;

    /**
     * KategoriaController constructor.
     * @param KategoriaRepository $kategoriaRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(KategoriaRepository $kategoriaRepository, PaginatorInterface $paginator)
    {
        $this->kategoriaRepository = $kategoriaRepository;
        $this->paginator = $paginator;
    }


    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="kategoria_index",
     * )
     */
    public function index(Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $this->kategoriaRepository->queryAll(),
            $request->query->getInt('page', 1),
            KategoriaRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'kategoria/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Kategoria $kategoria Kategoria entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="kategoria_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Kategoria $kategoria): Response
    {
        return $this->render(
            'kategoria/show.html.twig',
            ['kategoria' => $kategoria]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\KategoriaRepository $kategoriaRepository Kategoria repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="kategoria_create",
     * )
     */
    public function create(Request $request, KategoriaRepository $kategoriaRepository): Response
    {
        $kategoria = new Kategoria();
        $form = $this->createForm(KategoriaType::class, $kategoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $kategoriaRepository->save($kategoria);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('kategoria_index');
        }

        return $this->render(
            'kategoria/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Kategoria $kategoria Kategoria entity
     * @param \App\Repository\KategoriaRepository $kategoriaRepository Kategoria repository
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
     *     name="kategoria_edit",
     * )
     */
    public function edit(Request $request, Kategoria $kategoria, KategoriaRepository $kategoriaRepository): Response
    {
        $form = $this->createForm(KategoriaType::class, $kategoria, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $kategoriaRepository->save($kategoria);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('kategoria_index');
        }

        return $this->render(
            'kategoria/edit.html.twig',
            [
                'form' => $form->createView(),
                'kategoria' => $kategoria,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Kategoria $kategoria Kategoria entity
     * @param \App\Repository\KategoriaRepository $kategoriaRepository Kategoria repository
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
     *     name="kategoria_delete",
     * )
     */
    public
    function delete(Request $request, Kategoria $kategoria, KategoriaRepository $kategoriaRepository): Response
    {
        if($kategoria->getPrzepis()->count()){
            $this->addFlash('warning','message_category_contains_tasks');
            return $this->redirectToRoute('kategoria_index');
        }
        $form = $this->createForm(FormType::class, $kategoria, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $kategoriaRepository->delete($kategoria);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('kategoria_index');
        }

        return $this->render(
            'kategoria/delete.html.twig',
            [
                'form' => $form->createView(),
                'kategoria' => $kategoria,
            ]
        );
    }

}
