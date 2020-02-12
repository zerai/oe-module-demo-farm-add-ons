<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Finder;

class PackagistItem implements ModuleItem
{
    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var string */
    private $url;

    /** @var string */
    private $repository;

    /**
     * PackagistItem constructor.
     * @param string $name
     * @param string $description
     * @param string $url
     * @param string $repository
     */
    private function __construct(string $name, string $description, string $url, string $repository)
    {
        $this->name = $name;
        $this->description = $description;
        $this->url = $url;
        $this->repository = $repository;
    }

    public static function create(string $name, string $description, string $url, string $repository): self
    {
        return new self($name, $description, $url, $repository);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getRepository(): string
    {
        return $this->repository;
    }
}
