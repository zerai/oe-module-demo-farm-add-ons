<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Infrastructure\Module\Container;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use OpenEMR\Modules\DemoFarmAddOns\Finder\ModuleFinder;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistModuleFinder;
use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web\TwigTrait;
use Psr\Container\NotFoundExceptionInterface;

class ModuleContainer implements ModuleContainerInterface
{
    use TwigTrait;
    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws ModuleContainerNotFoundException  No entry was found for **this** identifier.
     * @throws ModuleContainerException Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            throw new ModuleContainerNotFoundException();
        }

        try {
            return $this->$id();
        } catch (\Exception $exception) {
            throw new ModuleContainerException();
        }
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id): bool
    {
        return method_exists($this, $id);
    }

    public function isModuleStandAlone(): bool
    {
        return !file_exists($this->getGlobalsFile());
    }

    public function getGlobalsFile(): string
    {
        $interfaceRootDirectory = \dirname(__DIR__, 7);

        return $interfaceRootDirectory . DIRECTORY_SEPARATOR . "globals.php";
    }

    private function twig_service(): \Twig\Environment
    {
        if (!$this->isModuleStandAlone()) {
            require_once($this->getGlobalsFile());

            /** @var \Twig\Environment $twigFromOpenEMR */
            $twigFromOpenEMR = $GLOBALS['twig'];
            $moduleRootDirectory = \dirname(__DIR__, 4);
            $moduleLoader = new \Twig\Loader\FilesystemLoader("$moduleRootDirectory/src/Infrastructure/UI/Web/Templates");
            $twigFromOpenEMR->setLoader($moduleLoader);

            return $twigFromOpenEMR;
        }

        /** @var \Twig\Environment $twigFromModule */
        $twigFromModule = $this->getTwig();
        return $twigFromModule;
    }

    private function http_client_service(): HttpClient
    {
        return HttpClientDiscovery::find();
    }

    private function packagist_finder_service(): ModuleFinder
    {
        return new PackagistModuleFinder($this->http_client_service());
    }
}
