<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web;

trait TwigTrait
{
    /**
     * Create the Twig Engine object
     *
     * @param array <string> $config
     *
     * @return \Twig\Environment
     */
    protected function getTwig(array $config = []): \Twig\Environment
    {
        $moduleRoot = \dirname(__DIR__, 4);
        $loader = new \Twig\Loader\FilesystemLoader("$moduleRoot/src/Infrastructure/UI/Web/Templates");

        $twigOptions =[];

        // configure cache and add to $twigOptions

        // configure debug mode and add to $twigOptions

        $TwigEnvironment = new \Twig\Environment($loader, $twigOptions);


        // add twig extension if needed

        // i18n for twig
        //$TwigEnvironment->addExtension(new \Twig_Extensions_Extension_I18n());

        // should be optional
        $TwigEnvironment->addExtension(new \Twig\Extension\DebugExtension());

        return $TwigEnvironment;
    }


    /**
     * @param string $template
     * @param array <mixed> $variables
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(string $template, array $variables): string
    {
        return $this->getTwig()->render($template, $variables);
    }
}
