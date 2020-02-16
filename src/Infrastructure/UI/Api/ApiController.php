<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Api;

use OpenEMR\Modules\DemoFarmAddOns\Finder\ModuleFinder;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController
{
    /** @var ModuleFinder */
    private $moduleFinder;

    public function __construct(ModuleFinder $moduleFinder)
    {
        $this->moduleFinder = $moduleFinder;
    }

    public function __invoke(Request $request): Response
    {
        $data = [];
        $searchTerm = $request->request->get('searchTerm') ?? '';
        $collection = $this->moduleFinder->searchModule($searchTerm);
        $modules = $collection->getItems();
        $data = $this->serializeResults($modules);

        $response = new Response(
            json_encode(['result' => $data]),
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );


        return $response;
    }

    /**
     * @param array <PackagistItem> $modules
     * @return array <array<string, string>>
     */
    protected function serializeResults(array $modules): array
    {
        $data = [];
        /** @var PackagistItem $module */
        foreach ($modules as $module) {
            $data[] = ['name' => $module->getName(), 'url' => $module->getUrl(), 'downloads' => (string) $module->getDownloads()];
        }
        return $data;
    }
}
