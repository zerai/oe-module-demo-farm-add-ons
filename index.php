<?php declare(strict_types=1);

/**
 * This file is required, see official guidelines.
 * The guide not clarifying the content and the supposed intent.
 *
 * @see pag. 15 - https://www.open-emr.org/wiki/images/6/61/ModuleInstaller-DeveloperGuide.pdf - custom module section.
 */

use Laminas\HttpHandlerRunner\Emitter\SapiStreamEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistModuleFinder;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Api\ApiController;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web\DefaultController;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web\NotFoundController;
use OpenEMR\Modules\DemoFarmAddOns\Module;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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

$psr17Factory = new Psr17Factory();
$serverRequestFactory = new ServerRequestCreator(
    $psr17Factory, // serverRequestFactory
    $psr17Factory, // uriFactory
    $psr17Factory, // uploadedFileFactory
    $psr17Factory // streamFactory
);

$request = $serverRequestFactory->fromGlobals();
/**
 * Integrating with Legacy Sessions here, if needed.
 */
//$response = routerMatch($request, $container);
$response = routerMatch($request, $module->getContainer());

(new SapiStreamEmitter())->emit($response);


function routerMatch(ServerRequestInterface $request, ContainerInterface $container): ResponseInterface
{
    if ($request->getUri()->getPath() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/api/search/' ||
        $request->getUri()->getPath() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/api/search') {
        return (new ApiController($container->get(PackagistModuleFinder::class)))($request);
    }

    if ($request->getUri()->getPath() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/index.php' ||
        $request->getUri()->getPath() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/' ||
        $request->getUri()->getPath() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons') {

        return (new DefaultController($container->get(PackagistModuleFinder::class), $container->get(Environment::class)))($request);
    }

    return (new NotFoundController())();
}
