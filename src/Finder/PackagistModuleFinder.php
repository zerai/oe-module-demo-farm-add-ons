<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Finder;

use GuzzleHttp\Psr7\Request;
use Http\Client\Exception\HttpException;
use Http\Client\HttpClient;
use HttpRuntimeException;
use RuntimeException;

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
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function searchModule(string $queryString = ''): ModuleItemCollection
    {
        $jsonResponse = $this->doSend($queryString);
        $decodedResponse = json_decode($jsonResponse, true);
        $itemsFromResponse = $decodedResponse['results'];

        $packagistItemCollection = $this->buildCollection($itemsFromResponse);

        return $packagistItemCollection;
    }


    /**
     * @param string $queryString
     * @return string
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
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
            // TODO improve exception handeling - see php-http doc.
            throw new RuntimeException('Http error.');
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
