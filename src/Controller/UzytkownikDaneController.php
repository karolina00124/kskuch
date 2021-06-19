<?php
/**
 * UzytkownikDane controller.
 */
namespace App\Controller;


use App\Entity\UzytkownikDane;
use App\Form\UzytkownikDaneType;
use App\Repository\UzytkownikDaneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class UzytkownikDaneController.
 *
 * @Route("/uzytkownikDane")
 */
class UzytkownikDaneController extends AbstractController
{
    private UzytkownikDaneRepository $uzytkownikDaneRepository;

    /**
     * UzytkownikDaneController constructor.
     * @param UzytkownikDaneRepository $uzytkownikDaneRepository
     */
    public function __construct(UzytkownikDaneRepository $uzytkownikDaneRepository)
    {
        $this->uzytkownikDaneRepository = $uzytkownikDaneRepository;
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
     *     name="uzytkownikDane_index",
     * )
     */
    public function index(uzytkownikDaneRepository $uzytkownikDaneRepository): Response
    {
        return $this->render(
            'uzytkownikDane/index.html.twig',
            ['uzytkownikDane' => $uzytkownikDaneRepository->findAll()]
        );
    }
    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\UzytkownikDaneRepository $uzytkownikDaneRepository UzytkownikDane repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="uzytkownikDane_create",
     * )
     */
    public function create(Request $request, UzytkownikDaneRepository $uzytkownikDaneRepository): Response
    {
        $uzytkownikDane = new UzytkownikDane();
        $form = $this->createForm(UzytkownikDaneType::class, $uzytkownikDane);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uzytkownikDaneRepository->save($uzytkownikDane);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('uzytkownikDane_index');
        }

        return $this->render(
            'uzytkownikDane/create.html.twig',
            ['form' => $form->createView()]
        );
    }
}