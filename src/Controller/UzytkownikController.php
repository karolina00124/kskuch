<?php
/**
 * Uzytkownik controller.
 */

namespace App\Controller;

use App\Entity\Uzytkownik;
use App\Form\RejestracjaType;
use App\Form\UzytkownikType;
use App\Service\UzytkownikService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UzytkownikController.
 */
class UzytkownikController extends AbstractController
{
    private UzytkownikService $uzytkownikService;

    /**
     * UzytkownikController constructor.
     *
     * @param UzytkownikService $uzytkownikService
     */
    public function __construct(UzytkownikService $uzytkownikService)
    {
        $this->uzytkownikService = $uzytkownikService;
    }

    /**
     * @Route("/register", name="user_register")
     *
     * @param Request $request
     *
     * @return Response HTTP Response
     *
     * @throws ORMException
     */
    public function register(Request $request): Response
    {
        $form = $this->createForm(RejestracjaType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->uzytkownikService->register($form->getData());
            $this->addFlash('success', 'message_registered_successfully');

            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'uzytkownik/rejestracja.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route(
     *     "/admin/user/editOwnProfile",
     *     methods={"GET", "POST"},
     *     name="user_edit_own_profile"
     * )
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function editOwnProfile(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(UzytkownikType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPasswordPlain = $form->get('newPassword')->getData();
            $this->uzytkownikService->save($user, $newPasswordPlain);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('user_edit_own_profile');
        }

        return $this->render(
            'uzytkownik/edit_own_profile.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/uzytkownik",
     *     methods={"GET"},
     *     name="uzytkownik_index",
     * )
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(Request $request): Response
    {
        return $this->render(
            'uzytkownik/index.html.twig',
            ['pagination' => $this->uzytkownikService->createPaginatedList($request->query->getInt('page', 1))]
        );
    }

    /**
     * Show action.
     *
     * @param Uzytkownik $uzytkownik Uzytkownik entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/uzytkownik/{id}",
     *     methods={"GET"},
     *     name="uzytkownik_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(Uzytkownik $uzytkownik): Response
    {
        return $this->render(
            'uzytkownik/show.html.twig',
            ['uzytkownik' => $uzytkownik]
        );
    }

    /**
     * Delete action.
     *
     * @param Request    $request    HTTP request
     * @param Uzytkownik $uzytkownik Uzytkownik entity
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/uzytkownik/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="uzytkownik_delete",
     * )
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Uzytkownik $uzytkownik): Response
    {
        $form = $this->createForm(FormType::class, $uzytkownik, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->uzytkownikService->delete($uzytkownik);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('uzytkownik_index');
        }

        return $this->render(
            'uzytkownik/delete.html.twig',
            [
                'form' => $form->createView(),
                'uzytkownik' => $uzytkownik,
            ]
        );
    }

    /**
     * Edit user for admin.
     *
     * @Route(
     *     "/uzytkownik/{id}/edit",
     *     methods={"GET", "POST"},
     *     name="uzytkownik_edit",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @param Request    $request    HTTP request
     * @param Uzytkownik $uzytkownik Uzytkownik entity
     *
     * @return Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Uzytkownik $uzytkownik): Response
    {
        $form = $this->createForm(UzytkownikType::class, $uzytkownik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPasswordPlain = $form->get('newPassword')->getData();
            $this->uzytkownikService->save($uzytkownik, $newPasswordPlain);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('uzytkownik_edit', ['id' => $uzytkownik->getId()]);
        }

        return $this->render(
            'uzytkownik/edit.html.twig',
            ['form' => $form->createView(), 'uzytkownik' => $uzytkownik]
        );
    }
}
