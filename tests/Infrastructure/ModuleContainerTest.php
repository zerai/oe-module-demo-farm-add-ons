<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Tests\Infrastructure;

use Http\Client\HttpClient;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistModuleFinder;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\Module\Container\ModuleContainer;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\Module\Container\ModuleContainerNotFoundException;
use PHPUnit\Framework\TestCase;
use Twig\Environment;

class ModuleContainerTest extends TestCase
{
    /** @test */
    public function can_detect_module_stand_alone_mode():void
    {
        $container = new ModuleContainer();

        self::assertTrue($container->isModuleStandAlone());
    }

    /**
     * @test
     * @dataProvider  list_of_configured_services
     */
    public function it_can_return_a_configured_service_by_service_name(string $serviceName, string $className): void
    {
        $container = new ModuleContainer();

        self::assertInstanceOf($className, $container->get($serviceName));
    }

    /**
     * @return \Generator <array>
     */
    public function list_of_configured_services(): \Generator
    {
        return [
            yield ['twig_service', Environment::class],
            yield ['http_client_service', HttpClient::class],
            yield ['packagist_finder_service', PackagistModuleFinder::class],
        ];
    }

    /**
     * @test
     * @dataProvider  list_of_unconfigured_services
     */
    public function it_throw_exception_for_unknow_services(string $serviceName): void
    {
        $this->expectException(ModuleContainerNotFoundException::class);
        $container = new ModuleContainer();

        $container->get($serviceName);
    }

    /**
     * @return \Generator <array>
     */
    public function list_of_unconfigured_services(): \Generator
    {
        return [
            yield [''],
            yield ['foo'],
            yield ['bar'],
            yield ['$%/()==?%$$'],
            yield ['twig'],
            yield ['http_client'],
            yield ['packagist_finder'],
        ];
    }


    /**
     * @test
     * @dataProvider  list_of_available_services
     */
    public function it_has_a_list_of_available_services(string $serviceName): void
    {
        $container = new ModuleContainer();

        self::assertTrue($container->has($serviceName));
    }

    /**
     * @return \Generator <array>
     */
    public function list_of_available_services(): \Generator
    {
        return [
            yield ['twig_service'],
            yield ['http_client_service'],
            yield ['packagist_finder_service'],
        ];
    }
}
