<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Tests\ModuleFinder;

use Http\Mock\Client;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistModuleFinder;
use PHPUnit\Framework\TestCase;

class PackagistModuleFinderTest extends TestCase
{
    use PackagistHttpResponseTrait;

    /** @test */
    public function can_find_one_module():void
    {
        $client = $this->createHttpClientWithDefaultResponse($this->packagistDefaultSingleResultResponseContent());
        $packagistModuleFinder = new PackagistModuleFinder($client);

        $foundedModulesCollection = $packagistModuleFinder->searchModule();

        self::assertEquals(1, $foundedModulesCollection->count());
    }

    /** @test */
    public function can_find_multiple_module():void
    {
        $client = $this->createHttpClientWithDefaultResponse($this->packagistDefaultMultipleResultResponseContent());
        $packagistModuleFinder = new PackagistModuleFinder($client);

        $foundedModulesCollection = $packagistModuleFinder->searchModule();

        self::assertEquals(2, $foundedModulesCollection->count());
    }

    private function createHttpClientWithDefaultResponse(string $contentResponse, int $httpStatusCode = 200): Client
    {
        $client = new Client();

        $stream = $this->createMock('Psr\Http\Message\StreamInterface');
        $stream->expects(self::any())->method('getContents')->willReturn($contentResponse);

        $response = $this->createMock('Psr\Http\Message\ResponseInterface');
        $response->expects(self::any())->method('getStatusCode')->willReturn($httpStatusCode);
        $response->expects(self::any())->method('getBody')->willReturn($stream);

        $client->setDefaultResponse($response);

        return $client;
    }

    /** @test */
    public function httpClientTest(): void
    {
        $stream = $this->createMock('Psr\Http\Message\StreamInterface');
        $stream->method('getContents')->willReturn($this->packagistDefaultSingleResultResponseContent());
        $response = $this->createMock('Psr\Http\Message\ResponseInterface');
        $response->method('getBody')->willReturn($stream);
        $client = $this->createHttpClientWithDefaultResponse($this->packagistDefaultSingleResultResponseContent());

        $returnedResponse = $client->sendRequest($this->createMock('Psr\Http\Message\RequestInterface'));

        $this->assertEquals($response, $returnedResponse);
        $this->assertEquals(200, $returnedResponse->getStatusCode());
    }

    /** @test */
    public function can_build_a_collection(): void
    {
        self::markTestSkipped();
    }
}
