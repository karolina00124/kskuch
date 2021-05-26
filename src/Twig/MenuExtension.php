<?php

namespace App\Twig;

use App\Repository\KategoriaRepository;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MenuExtension extends AbstractExtension
{
    /**
     * @var KategoriaRepository
     */
    private $kategoriaRepository;

    public function __construct(KategoriaRepository $kategoriaRepository)
    {
        $this->kategoriaRepository = $kategoriaRepository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('renderMenu', [$this, 'renderMenu'], ['needs_environment' => true, 'is_safe' => ['html']])
        ];
    }

    public function renderMenu(Environment $environment)
    {
        $kategorie = $this->kategoriaRepository->getAll();

        return $environment->render('menu.html.twig', ['kategorie' => $kategorie]);
    }
}
