<?php

declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

class Module
{
    public const MODULE_NAME = 'Demo Farm add-ons';

    public const MODULE_VERSION = 'v0.2.7';

    public const MODULE_SOURCE_CODE = 'https://github.com/zerai/oe-module-demo-farm-add-ons';

    public const VENDOR_NAME = 'Zerai';

    public const VENDOR_URL = 'https://github.com/zerai';

    /**
     * @var null|ContainerInterface
     */
    protected $container = null;

    public static function bootstrap(): self
    {
        $module = new self();
        $container = $module->buildContainer();
        $module->container = $container;

        return $module;
    }

    private function buildContainer(): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);
        $containerBuilder->addDefinitions(__DIR__ . '/../config/di/monolog.php');
        $containerBuilder->addDefinitions(__DIR__ . '/../config/di/twig.php');
        $containerBuilder->addDefinitions(__DIR__ . '/../config/di/service.php');

        return $containerBuilder->build();
    }

    public static function isStandAlone(): bool
    {
        $interfaceRootDirectory = \dirname(__DIR__, 4);
        $openemrGlobalFile = $interfaceRootDirectory . DIRECTORY_SEPARATOR . "globals.php";
        return ! file_exists($openemrGlobalFile);
    }

    public static function mainDir(): string
    {
        return \dirname(__DIR__, 1);
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
