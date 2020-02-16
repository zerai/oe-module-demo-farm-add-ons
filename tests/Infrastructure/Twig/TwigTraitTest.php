<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Tests\Infrastructure\Twig;

use PHPUnit\Framework\TestCase;
use Twig\Environment;

class TwigTraitTest extends TestCase
{
    /** @test */
    public function can_return_a_twig_instance(): void
    {
        $sut = new ImplementedTwigTrait();

        self::assertInstanceOf(Environment::class, $sut->template()) ;
    }

    /** @test */
    public function can_render_a_template(): void
    {
        $sut = new ImplementedTwigTrait();

        $renderedTemplate = $sut->render('test.html.twig', ['foo' => 'foo']);

        self::assertIsString($renderedTemplate); // InstanceOf(Environment::class, $sut->template()) ;
    }
}
