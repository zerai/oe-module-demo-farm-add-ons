<?php declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Api;

use Nyholm\Psr7\Factory\Psr17Factory;
use OpenEMR\Modules\DemoFarmAddOns\Finder\ModuleFinder;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistItem;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ApiController
{
    /**
     * @var ModuleFinder
     */
    private $moduleFinder;

    public function __construct(ModuleFinder $moduleFinder)
    {
        $this->moduleFinder = $moduleFinder;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $searchTerm = $request->getParsedBody()['searchTerm'];
        try {
            $collection = $this->moduleFinder->searchModule($searchTerm);
            $modules = $collection->getItems();
            $data = $this->serializeResults($modules);

            $jsonData = json_encode($data, JSON_THROW_ON_ERROR);
        } catch (\Exception $exception) {
            //TODO set a error reponse template
        }

        $psr17Factory = new Psr17Factory();
        $responseBody = $psr17Factory->createStream($jsonData);

        return $psr17Factory->createResponse(200)
            ->withBody($responseBody)
            ->withAddedHeader('Content-type', 'application/json');
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
            $data[] = [
                'name' => $module->getName(),
                'url' => $module->getUrl(),
                'downloads' => (string) $module->getDownloads(),
            ];
        }
        return $data;
    }
}
