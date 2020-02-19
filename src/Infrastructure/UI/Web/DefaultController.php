<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web;

use OpenEMR\Modules\DemoFarmAddOns\Finder\ModuleFinder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class DefaultController
{
    /** @var ModuleFinder */
    private $moduleFinder;

    /** @var Environment */
    private $twigEnvironment;

    /**
     * DefaultController constructor.
     */
    public function __construct(ModuleFinder $moduleFinder, Environment $twigEnvironment)
    {
        $this->moduleFinder = $moduleFinder;
        $this->twigEnvironment = $twigEnvironment;
    }

    public function __invoke(Request $request): Response
    {
        $collection = $this->moduleFinder->searchModule();

        $modules = $collection->getItems();

        $response = new Response(
            $this->twigEnvironment->render('packagist/default.html.twig', ['modules' => $modules]),
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );

        return $response;
    }
}
