<?php

namespace App\Controller;

use App\Entity\Uzytkownik;
use App\Form\RejestracjaType;
use App\Repository\UzytkownikRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UzytkownikController extends AbstractController
{
    /**
     * @Route("/register", name="user_register")
     */
    public function register(Request $request, UzytkownikRepository $uzytkownikRepository)
    {
        $form = $this->createForm(RejestracjaType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uzytkownikRepository->register($form->getData());
            $this->addFlash('success', 'message_registered_successfully');
            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'uzytkownik/rejestracja.html.twig',
            ['form' => $form->createView()]
        );
    }
}