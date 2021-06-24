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
    private KategoriaRepository $kategoriaRepository;

    public function __construct(KategoriaRepository $kategoriaRepository)
    {
        $this->kategoriaRepository = $kategoriaRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('renderMenu', [$this, 'renderMenu'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function renderMenu(Environment $environment): string
    {
        $kategorie = $this->kategoriaRepository->getAll();

        return $environment->render('menu.html.twig', ['kategorie' => $kategorie]);
    }
}
