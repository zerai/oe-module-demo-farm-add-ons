<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Finder;

use GuzzleHttp\Psr7\Request;
use Http\Client\HttpClient;

class PackagistModuleFinder implements ModuleFinder
{
    private const HOST = 'packagist.org';

    /** @var HttpClient */
    private $httpClient;

    /**
     * PackagistModuleFinder constructor.
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $queryString
     * @return PackagistItemCollection
     */
    public function searchModule(string $queryString = ''): ModuleItemCollection
    {
        $jsonResponse = $this->doSend($queryString);
        $decodedResponse = json_decode($jsonResponse, true);
        $itemsFromResponse = $decodedResponse['results'];

        $packagistItemCollection = $this->buildCollection($itemsFromResponse);

        return $packagistItemCollection;
    }

    // TODO change visibility in private
    public function doSend(string $queryString = ''): string
    {
        $endpoint = sprintf('https://%s/search.json?q=%s&type=openemr-module', self::HOST, $queryString);

        $response = $this->httpClient->sendRequest(
            new Request(
                'GET',
                $endpoint
            )
        );

        if (200 !== $response->getStatusCode()) {
            // TODO
            //throw new HttpRuntimeException
        }

        return $response->getBody()->getContents();
    }

    /**
     * @param iterable<array> $itemsFromResponse
     * @return PackagistItemCollection
     */
    public function buildCollection(iterable $itemsFromResponse): PackagistItemCollection
    {
        $packagistItems = [];

        foreach ($itemsFromResponse as $item) {
            $packagistItems[] = PackagistItem::create($item['name'], $item['description'], $item['url'], $item['repository'], $item['downloads']);
        }

        return new PackagistItemCollection($packagistItems);
    }
}
