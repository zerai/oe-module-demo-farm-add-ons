<?php declare(strict_types=1);

use OpenEMR\Modules\DemoFarmAddOns\Module;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;



$loader = new FilesystemLoader([
    Module::mainDir(). '/src/Infrastructure/UI/Web/Templates',
]);

$twigOptions = [];

$TwigEnvironment = new Environment($loader, $twigOptions);

$TwigEnvironment->addGlobal('module', [
    'name' => Module::MODULE_NAME,
    'version' => Module::MODULE_VERSION,
    'source_code' => Module::MODULE_SOURCE_CODE,
    'vendor_name' => Module::VENDOR_NAME,
    'vendor_url' => Module::VENDOR_URL,
    'isStandAlone' => Module::isStandAlone(),
]);

return [
    Environment::class => $TwigEnvironment,
];
