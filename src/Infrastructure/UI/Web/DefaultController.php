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

    public function __construct(ModuleFinder $moduleFinder, Environment $twigEnvironment)
    {
        $this->moduleFinder = $moduleFinder;
        $this->twigEnvironment = $twigEnvironment;
    }

    public function __invoke(Request $request): Response
    {
        $response = new Response();
        try {
            $response->setContent($this->twigEnvironment->render('packagist/default.html.twig'));
            $response->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $exception) {
            //TODO
        }

        $response->prepare($request);

        return $response;
    }
}
