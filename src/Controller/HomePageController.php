<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * Index action.
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="homepage_index"
     * )
     */
    public function index(): Response
    {
        return $this->render(   //kozystamy z metody renderowania odziedziczonej po AbastractController
            'homepage/index.html.twig'  //używamy szablonu twig
        );

    }
}