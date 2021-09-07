<?php
/**
 * MenuExtension
 */

namespace App\Twig;

use App\Repository\KategoriaRepository;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * MenuExtension class
 */
class MenuExtension extends AbstractExtension
{
    private KategoriaRepository $kategoriaRepository;

    /**
     * @param KategoriaRepository $kategoriaRepository
     */
    public function __construct(KategoriaRepository $kategoriaRepository)
    {
        $this->kategoriaRepository = $kategoriaRepository;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('renderMenu', [$this, 'renderMenu'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    /**
     * @param Environment $environment
     *
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     *
     * @return string
     */
    public function renderMenu(Environment $environment): string
    {
        $kategorie = $this->kategoriaRepository->getAll();

        return $environment->render('menu.html.twig', ['kategorie' => $kategorie]);
    }
}
