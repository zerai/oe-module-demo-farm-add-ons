<?php declare(strict_types=1);

/**
 * This file is required, see official guidelines.
 * The guide not clarifying the content and the supposed intent.
 *
 * @see pag. 15 - https://www.open-emr.org/wiki/images/6/61/ModuleInstaller-DeveloperGuide.pdf - custom module section.
 */

use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistModuleFinder;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\Module\Container\ModuleContainer;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Api\ApiController;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web\DefaultController;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web\NotFoundController;
use OpenEMR\Modules\DemoFarmAddOns\Module;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

require __DIR__ . '/src/Module.php';

if (Module::isStandAlone()) {
    require __DIR__ . '/vendor/autoload.php';
} else {
    require __DIR__ . '/../../../../vendor/autoload.php';
}

$module = Module::bootstrap();

$request = Request::createFromGlobals();
/**
 * Integrating with Legacy Sessions here, if needed.
 */
//$response = routerMatch($request, $container);
$response = routerMatch($request, $module->getContainer());
$response->send();



function routerMatch(Request $request,  $container): Response
{
    if ($request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/api/search/' ||
        $request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/api/search') {
        return (new ApiController($container->get(PackagistModuleFinder::class)))($request);
    }

    if ($request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/index.php' ||
        $request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/' ||
        $request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons') {

        return (new DefaultController($container->get(PackagistModuleFinder::class), $container->get(Environment::class)))($request);
    }

    return (new NotFoundController())();
}
