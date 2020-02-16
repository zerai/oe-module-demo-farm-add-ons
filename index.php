<?php
declare(strict_types=1);

/**
 * This file is required, see official guidelines.
 * The guide not clarifying the content and the supposed intent.
 *
 * @see pag. 15 - https://www.open-emr.org/wiki/images/6/61/ModuleInstaller-DeveloperGuide.pdf - custom module section.
 */

require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once(__DIR__ . "/../../../globals.php");

use OpenEMR\Core\Header;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Api\ApiController;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web\DefaultController;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web\NotFoundController;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web\TwigController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
/**
 * Integrating with Legacy Sessions here, if needed.
 */
$response = routerMatch($request);
$response->send();



function routerMatch(Request $request): Response
{
    // TODO remove twig test
    if ($request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/twig-test/' ||
        $request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/twig-test') {
        return (new TwigController())();
    }
    if ($request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/api/' ||
        $request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/api') {
        return (new ApiController())();
    }

    if ($request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/index.php' ||
        $request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons/' ||
        $request->getRequestUri() === '/interface/modules/custom_modules/oe-module-demo-farm-add-ons') {
        return (new DefaultController(null, null))($request);
    }

    return (new NotFoundController())();
}
