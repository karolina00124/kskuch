<?php
/**
 * HomePage controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class HomePageController extends AbstractController
{
    /**
     * Index action.
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="homepage_index"
     * )
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render(   //kozystamy z metody renderowania odziedziczonej po AbastractController
            'homepage/index.html.twig'  //używamy szablonu twig
        );
    }
}
