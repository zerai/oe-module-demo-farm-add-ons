<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Tests\ModuleFinder;

use OpenEMR\Modules\DemoFarmAddOns\Finder\ModuleItemCollection;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistItem;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistItemCollection;
use PHPUnit\Framework\TestCase;

class PackagistItemCollectionTest extends TestCase
{
    private const IRRELEVANT = 'irrelevant';

    use PackagistHttpResponseTrait;

    /** @test */
    public function can_be_created(): void
    {
        $collection = new PackagistItemCollection();

        self::assertInstanceOf(ModuleItemCollection::class, $collection);
        self::assertInstanceOf(PackagistItemCollection::class, $collection);
    }

    /** @test */
    public function can_be_created_with_data(): void
    {
        $data = [
            packagistItem::create(
                self::IRRELEVANT,
                self::IRRELEVANT,
                self::IRRELEVANT,
                self::IRRELEVANT,
                10
            )
        ];

        $collection = new PackagistItemCollection($data);

        self::assertInstanceOf(PackagistItemCollection::class, $collection);
    }

    /** @test */
    public function can_count_internal_elements(): void
    {
        $data = [
            packagistItem::create(
                self::IRRELEVANT,
                self::IRRELEVANT,
                self::IRRELEVANT,
                self::IRRELEVANT,
                10
            ),
            packagistItem::create(
                self::IRRELEVANT,
                self::IRRELEVANT,
                self::IRRELEVANT,
                self::IRRELEVANT,
                10
            )
        ];

        $collection = new PackagistItemCollection($data);


        self::assertEquals(2, $collection->count());
    }

    /** @test */
    public function can_return_elements_as_array(): void
    {
        $data = [
            packagistItem::create(
                self::IRRELEVANT,
                self::IRRELEVANT,
                self::IRRELEVANT,
                self::IRRELEVANT,
                10
            ),
            packagistItem::create(
                self::IRRELEVANT,
                self::IRRELEVANT,
                self::IRRELEVANT,
                self::IRRELEVANT,
                10
            )
        ];
        $collection = new PackagistItemCollection($data);

        $items = $collection->getItems();

        self::assertTrue(is_array($items));
    }
}
