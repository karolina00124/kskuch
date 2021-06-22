<?php
/**
 *Komentarz controller.
 */
namespace App\Controller;

use App\Entity\Komentarz;
use App\Form\KomentarzType;
use App\Repository\KomentarzRepository;
use App\Repository\PrzepisRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class KomentarzController.
 *
 * @Route("/komentarz")
 */
class KomentarzController extends AbstractController
{
    private KomentarzRepository $komentarzRepository;

    private PaginatorInterface $paginator;

    /**
     * KomentarzController constructor.
     * @param KomentarzRepository $komentarzRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(KomentarzRepository $komentarzRepository, PaginatorInterface $paginator)
    {
        $this->komentarzRepository = $komentarzRepository;
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
     *     name="komentarz_index",
     * )
     */
    public function index(Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $this->komentarzRepository->queryAll(),
            $request->query->getInt('page', 1),
            KomentarzRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'komentarz/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Komentarz $komentarz Komentarz entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="komentarz_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Komentarz $komentarz): Response
    {
        return $this->render(
            'komentarz/show.html.twig',
            ['komentarz' => $komentarz]
        );
    }
    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\KomentarzRepository $komentarzRepository Komentarz repository
     * @param int $przepisId Id przepisu
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{przepisId}/create",
     *     methods={"GET", "POST"},
     *     name="komentarz_create",
     * )
     */
    public function create(Request $request, KomentarzRepository $komentarzRepository, PrzepisRepository $przepisRepository, int $przepisId): Response
    {
        $przepis = $przepisRepository->find($przepisId);

        $komentarz = new Komentarz();
        $form = $this->createForm(KomentarzType::class, $komentarz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $komentarz->setAutor($this->getUser());
            $komentarz->setPrzepis($przepis);
            $komentarzRepository->save($komentarz);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('przepis_show', ['id' => $przepisId]);
        }

        return $this->render(
            'komentarz/create.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('komentarz_create', ['przepisId' => $przepisId]),
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Komentarz $komentarz Komentarz entity
     * @param \App\Repository\KomentarzRepository $komentarzRepository Komentarz repository
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
     *     name="komentarz_edit",
     * )
     */
    public function edit(Request $request, Komentarz $komentarz, KomentarzRepository $komentarzRepository): Response
    {
        $form = $this->createForm(KomentarzType::class, $komentarz, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $komentarzRepository->save($komentarz);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('komentarz_index');
        }

        return $this->render(
            'komentarz/edit.html.twig',
            [
                'form' => $form->createView(),
                'komentarz' => $komentarz,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Komentarz $komentarz Komentarz entity
     * @param \App\Repository\KomentarzRepository $komentarzRepository Komentarz repository
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
     *     name="komentarz_delete",
     * )
     */
    public
    function delete(Request $request, Komentarz $komentarz, KomentarzRepository $komentarzRepository): Response
    {
        $form = $this->createForm(FormType::class, $komentarz, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $komentarzRepository->delete($komentarz);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('komentarz_index');
        }

        return $this->render(
            'komentarz/delete.html.twig',
            [
                'form' => $form->createView(),
                'komentarz' => $komentarz,
            ]
        );
    }
}