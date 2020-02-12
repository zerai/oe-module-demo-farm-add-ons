<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Tests\ModuleFinder;

use OpenEMR\Modules\DemoFarmAddOns\Finder\ModuleItemCollection;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistItemCollection;
use PHPUnit\Framework\TestCase;

class PackagistItemCollectionTest extends TestCase
{
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
        $response = $this->packagistDefaultSingleResultResponseContent();
        $decodedResponse = json_decode($response, true);
        $items = $decodedResponse['results'];

        $collection = new PackagistItemCollection($items);

        self::assertInstanceOf(PackagistItemCollection::class, $collection);
    }

    /** @test */
    public function can_count_internal_elements(): void
    {
        $response = $this->packagistDefaultMultipleResultResponseContent();
        $decodedResponse = json_decode($response, true);
        $items = $decodedResponse['results'];
        $collection = new PackagistItemCollection($items);


        self::assertEquals(2, $collection->count());
    }

    /** @test */
    public function can_return_elements_as_array(): void
    {
        $response = $this->packagistDefaultMultipleResultResponseContent();
        $decodedResponse = json_decode($response, true);
        $items = $decodedResponse['results'];
        $collection = new PackagistItemCollection($items);

        $items = $collection->getItems();
        self::assertTrue(is_array($items));
    }
}
