<?php declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Tests\ModuleFinder;

use OpenEMR\Modules\DemoFarmAddOns\Finder\ModuleItem;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistItem;
use PHPUnit\Framework\TestCase;

class PackagistItemTest extends TestCase
{
    private const IRRELEVANT = 'irrelevant';

    /**
     * @test
     */
    public function can_be_created(): void
    {
        $packagistItem = PackagistItem::create(
            self::IRRELEVANT,
            self::IRRELEVANT,
            self::IRRELEVANT,
            self::IRRELEVANT,
            100
        );

        self::assertInstanceOf(ModuleItem::class, $packagistItem);
        self::assertInstanceOf(PackagistItem::class, $packagistItem);
        self::assertSame(self::IRRELEVANT, $packagistItem->getName());
        self::assertSame(self::IRRELEVANT, $packagistItem->getDescription());
        self::assertSame(self::IRRELEVANT, $packagistItem->getUrl());
        self::assertSame(self::IRRELEVANT, $packagistItem->getRepository());
        self::assertSame(100, $packagistItem->getDownloads());
    }
}
