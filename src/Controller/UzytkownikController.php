<?php
/**
 * Uzytkownik controller.
 */
namespace App\Controller;

use App\Form\RejestracjaType;
use App\Form\UzytkownikType;
use App\Service\UzytkownikService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UzytkownikController extends AbstractController
{
    /**
     * @var UzytkownikService
     */
    private $uzytkownikService;

    /**
     * @Route("/register", name="user_register")
     */
    public function register(Request $request)
    {
        $form = $this->createForm(RejestracjaType::class, null);
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
     * @Route("/admin/user/edit", methods={"GET", "POST"}, name="user_edit")
     *
     * @param Request $request
     * @param UzytkownikService $uzytkownikService
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(UzytkownikType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPasswordPlain = $form->get('newPassword')->getData();
            $this->uzytkownikService->save($user, $newPasswordPlain);
            $this->addFlash('success', 'message_updated_successfully');
            return $this->redirectToRoute('user_edit');
        }

        return $this->render(
            'uzytkownik/edit.html.twig',
            ['form' => $form->createView()]
        );
    }

}