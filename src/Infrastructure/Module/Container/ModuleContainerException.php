<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Infrastructure\Module\Container;

use Psr\Container\ContainerExceptionInterface;

class ModuleContainerException extends \Exception implements ContainerExceptionInterface
{
}
