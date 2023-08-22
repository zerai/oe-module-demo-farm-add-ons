<?php declare(strict_types=1);


use Http\Discovery\HttpClientDiscovery;
use OpenEMR\Modules\DemoFarmAddOns\Finder\ModuleFinder;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistModuleFinder;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web\DefaultController;
use Twig\Environment;

return [
    PackagistModuleFinder::class => DI\object()
        ->constructor(DI\factory([HttpClientDiscovery::class, 'find'])),
    ModuleFinder::class => DI\object(PackagistModuleFinder::class),
    DefaultController::class => DI\object()
        ->constructor(DI\get(ModuleFinder::class), DI\get(Environment::class)),
];

