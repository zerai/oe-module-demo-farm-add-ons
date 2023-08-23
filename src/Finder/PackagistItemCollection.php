<?php

declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Finder;

use Doctrine\Common\Collections\ArrayCollection;
use Webmozart\Assert\Assert;

class PackagistItemCollection implements ModuleItemCollection
{
    /**
     * @var ArrayCollection <int,PackagistItem>
     */
    private $collection;

    /**
     * PackagistItemCollection constructor.
     * @param iterable <PackagistItem> $collection
     */
    public function __construct(iterable $collection = [])
    {
        Assert::allIsInstanceOf($collection, PackagistItem::class);
        $this->collection = new ArrayCollection((array) $collection);
    }

    public function count(): int
    {
        return $this->collection->count();
    }

    /**
     * @return array <PackagistItem>
     */
    public function getItems(): array
    {
        return $this->collection->toArray();
    }
}
