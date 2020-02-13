<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Tests\ModuleFinder;

use Exception;
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

    /** @test */
    public function can_handle_http_exception():void
    {
        $this->expectException(\RuntimeException::class);

        $clientException = new \RuntimeException('Whoops! The server is down.');
        $client = $this->createHttpClientWithExceptionResponse($clientException, 500);
        $packagistModuleFinder = new PackagistModuleFinder($client);

        $packagistModuleFinder->searchModule();
    }

    /** @test */
    public function can_build_a_collection(): void
    {
        self::markTestSkipped();
    }

    /**
     * This is an edge case, the module system is based on "openemr/oe-module-installer-plugin"
     * it should always appear in the search results.
     * 0 result should never happen.
     *
     * @test
     */
    public function can_handle_a_empty_respose_content():void
    {
        $client = $this->createHttpClientWithDefaultResponse($this->packagistEmptyResponseContent());
        $packagistModuleFinder = new PackagistModuleFinder($client);

        $foundedModulesCollection = $packagistModuleFinder->searchModule();

        self::assertEquals(0, $foundedModulesCollection->count());
    }

    /** @test */
    public function can_generate_an_valid_http_endpoint_without_an_input_queryString_parameter(): void
    {
        $expectedEndpoint = 'https://packagist.org/search.json?q=&type=openemr-module';

        $packagistModuleFinder = new PackagistModuleFinder($client = new Client());

        $endpoint = $packagistModuleFinder->endpoint();

        self::assertStringContainsString('type=openemr-module', $endpoint);
        self::assertSame($expectedEndpoint, $endpoint);
        self::assertTrue((bool) filter_var($endpoint, FILTER_VALIDATE_URL));
    }

    /** @test */
    public function can_generate_an_valid_http_endpoint_from_an_input_queryString_parameter(): void
    {
        $queryString = 'vendor_1';

        $expectedEndpoint = 'https://packagist.org/search.json?q='.$queryString.'&type=openemr-module';

        $packagistModuleFinder = new PackagistModuleFinder($client = new Client());

        $endpoint = $packagistModuleFinder->endpoint($queryString);

        self::assertStringContainsString('type=openemr-module', $endpoint);
        self::assertSame($expectedEndpoint, $endpoint);
        self::assertTrue((bool) filter_var($endpoint, FILTER_VALIDATE_URL));
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

    private function createHttpClientWithExceptionResponse(Exception $exception, int $httpStatusCode): Client
    {
        $client = new Client();
        $client->addException($exception);

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
}
