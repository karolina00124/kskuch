<?php
/**
 * Przepis controller.
 */

namespace App\Controller;

use App\Entity\Przepis;
use App\Form\PrzepisType;
use App\Form\VoteType;
use App\Service\PrzepisService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PrzepisController.
 *
 * @Route("/przepis")
 */
class PrzepisController extends AbstractController
{
    private PrzepisService $przepisService;

    /**
     * PrzepisController constructor.
     *
     * @param PrzepisService $przepisService
     */
    public function __construct(PrzepisService $przepisService)
    {
        $this->przepisService = $przepisService;
    }

    /**
     * Index action.
     *
     * @param Request $request
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="przepis_index",
     * )
     */
    public function index(Request $request): Response
    {
        $filters = [];
        $filters['kategoria_id'] = $request->query->getInt('filters_kategoria_id');
        $filters['tag_id'] = $request->query->getInt('filters_tag_id');
        $filters['autor_id'] = $request->query->getInt('filters_autor_id');

        return $this->render(
            'przepis/index.html.twig',
            ['pagination' => $this->przepisService->createPaginatedList($request->query->getInt('page', 1), $filters)]
        );
    }

    /**
     * Show action.
     *
     * @param Przepis $przepis Przepis entity
     *
     * @return Response HTTP response
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
        $voteForm = $this->createForm(VoteType::class, $przepis, [
            'method' => 'PATCH',
            'thumbUpCnt' => $przepis->getThumbUp(),
            'thumbDownCnt' => $przepis->getThumbDown(),
        ]);

        return $this->render(
            'przepis/show.html.twig',
            ['przepis' => $przepis, 'voteForm' => $voteForm->createView()]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="przepis_create",
     * )
     * @IsGranted("ROLE_ADMIN","ROLE_USER")
     */
    public function create(Request $request): Response
    {
        $przepis = new Przepis();
        $form = $this->createForm(PrzepisType::class, $przepis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $przepis->setAuthor($this->getUser());
            $this->przepisService->save($przepis);

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
     * @param Request $request HTTP request
     * @param Przepis $przepis Przepis entity
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="przepis_edit",
     * )
     */
    public function edit(Request $request, Przepis $przepis): Response
    {
        if (!($this->isGranted('ROLE_ADMIN') || $przepis->getAuthor() === $this->getUser())) {
            $this->addFlash('warning', 'message.item_not_found');

            return $this->redirectToRoute('przepis_index');
        }

        $form = $this->createForm(PrzepisType::class, $przepis, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->przepisService->save($przepis);

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
     * @param Request $request HTTP request
     * @param Przepis $przepis Przepis entity
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="przepis_delete",
     * )
     */
    public function delete(Request $request, Przepis $przepis): Response
    {
        if (!($this->isGranted('ROLE_ADMIN') || $przepis->getAuthor() === $this->getUser())) {
            $this->addFlash('warning', 'message.item_not_found');

            return $this->redirectToRoute('przepis_index');
        }

        $form = $this->createForm(FormType::class, $przepis, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->przepisService->delete($przepis);
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

    /**
     * Vote action.
     *
     * @param Request $request HTTP request
     * @param Przepis $przepis Przepis entity
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/vote",
     *     methods={"PATCH"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="przepis_vote",
     * )
     */
    public function vote(Request $request, Przepis $przepis): Response
    {
        $form = $this->createForm(VoteType::class, $przepis, ['method' => 'PATCH']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $action = $form->get('thumbUp')->isClicked() ? 'up' : 'down';

            if ('up' === $action) {
                $this->przepisService->voteUp($przepis);
            } elseif ('down' === $action) {
                $this->przepisService->voteDown($przepis);
            }
        }

        return $this->redirectToRoute('przepis_show', ['id' => $przepis->getId()]);
    }
}
