<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Tests\Infrastructure\Twig;

use OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web\TwigTrait;

class ImplementedTwigTrait
{
    use TwigTrait;

    public function template(): \Twig\Environment
    {
        return $this->getTwig([]);
    }
}
