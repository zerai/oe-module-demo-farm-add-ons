<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Infrastructure\Module\Container;

use Psr\Container\NotFoundExceptionInterface;

class ModuleContainerNotFoundException extends \Exception implements NotFoundExceptionInterface
{
}
