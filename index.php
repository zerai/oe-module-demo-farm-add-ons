<?php
declare(strict_types=1);

/**
 * This file is required, see official guidelines.
 * The guide not clarifying the content and the supposed intent.
 *
 * @see pag. 15 - https://www.open-emr.org/wiki/images/6/61/ModuleInstaller-DeveloperGuide.pdf - custom module section.
 */

require_once __DIR__ . '/../../../../vendor/autoload.php';

use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\Module\Container\ModuleContainer;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Api\ApiController;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web\DefaultController;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web\NotFoundController;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web\SearchController;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$container = new ModuleContainer();
$request = Request::createFromGlobals();
/**
 * Integrating with Legacy Sessions here, if needed.
 */
$response = routerMatch($request, $container);
$response->send();



function routerMatch(Request $request, ContainerInterface $container): Response
{

    // TODO REMOVE - SEARCH CONTROLLER TEST
    if ($request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/search/' ||
        $request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/search') {
        return (new SearchController($container->get('packagist_finder_service'), $container->get('twig_service')))($request);
    }

    if ($request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/api/' ||
        $request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/api') {
        return (new ApiController($container->get('packagist_finder_service')))($request);
    }

    if ($request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/api/search/' ||
        $request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/api/search') {
        return (new ApiController($container->get('packagist_finder_service')))($request);
    }

    if ($request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/index.php' ||
        $request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/' ||
        $request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons') {
        return (new DefaultController($container->get('packagist_finder_service'), $container->get('twig_service')))($request);
    }

    return (new NotFoundController())();
}
