<?php
/**
 *Komentarz controller.
 */

namespace App\Controller;

use App\Entity\Komentarz;
use App\Form\KomentarzType;
use App\Service\KomentarzService;
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
 * Class KomentarzController.
 *
 * @Route("/komentarz")
 */
class KomentarzController extends AbstractController
{
    private KomentarzService $komentarzService;

    private PrzepisService $przepisService;

    /**
     * KomentarzController constructor.
     *
     * @param KomentarzService $komentarzService
     * @param PrzepisService   $przepisService
     */
    public function __construct(KomentarzService $komentarzService, PrzepisService $przepisService)
    {
        $this->komentarzService = $komentarzService;
        $this->przepisService = $przepisService;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="komentarz_index",
     * )
     *
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(Request $request): Response
    {
        return $this->render(
            'komentarz/index.html.twig',
            ['pagination' => $this->komentarzService->createPaginatedList($request->query->getInt('page', 1))]
        );
    }

    /**
     * Show action.
     *
     * @param Komentarz $komentarz Komentarz entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="komentarz_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @IsGranted("ROLE_ADMIN")
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
     * @param Request $request   HTTP request
     * @param int     $przepisId Id przepisu
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{przepisId}/create",
     *     methods={"GET", "POST"},
     *     name="komentarz_create",
     * )
     */
    public function create(Request $request, int $przepisId): Response
    {
        $przepis = $this->przepisService->getOne($przepisId);

        $komentarz = new Komentarz();
        $form = $this->createForm(KomentarzType::class, $komentarz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $komentarz->setAutor($this->getUser());
            $komentarz->setPrzepis($przepis);
            $this->komentarzService->save($komentarz);

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
     * @param Request   $request   HTTP request
     * @param Komentarz $komentarz Komentarz entity
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
     *     name="komentarz_edit",
     * )
     *
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Komentarz $komentarz): Response
    {
        $form = $this->createForm(KomentarzType::class, $komentarz, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->komentarzService->save($komentarz);

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
     * @param Request   $request   HTTP request
     * @param Komentarz $komentarz Komentarz entity
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
     *     name="komentarz_delete",
     * )
     *
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Komentarz $komentarz): Response
    {
        $form = $this->createForm(FormType::class, $komentarz, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->komentarzService->delete($komentarz);
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
