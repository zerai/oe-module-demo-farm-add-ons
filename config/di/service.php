<?php declare(strict_types=1);

use Http\Discovery\HttpClientDiscovery;
use OpenEMR\Modules\DemoFarmAddOns\Finder\ModuleFinder;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistModuleFinder;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web\DefaultController;
use Twig\Environment;

return [
    PackagistModuleFinder::class => DI\create()
        ->constructor(DI\factory([HttpClientDiscovery::class, 'find'])),
    ModuleFinder::class => DI\create(PackagistModuleFinder::class),
    DefaultController::class => DI\create()
        ->constructor(DI\get(ModuleFinder::class), DI\get(Environment::class)),
];

