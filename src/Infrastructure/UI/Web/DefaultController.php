<?php declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web;

use Nyholm\Psr7\Factory\Psr17Factory;
use OpenEMR\Modules\DemoFarmAddOns\Finder\ModuleFinder;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class DefaultController
{
    /**
     * @var ModuleFinder
     */
    private $moduleFinder;

    /**
     * @var Environment
     */
    private $twigEnvironment;

    public function __construct(ModuleFinder $moduleFinder, Environment $twigEnvironment)
    {
        $this->moduleFinder = $moduleFinder;
        $this->twigEnvironment = $twigEnvironment;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        if ($request->getParsedBody() !== null) {
            $searchTerm = $request->getParsedBody()['searchTerm'];
        } else {
            $searchTerm = '';
        }

        try {
            $collection = $this->moduleFinder->searchModule($searchTerm)->getItems();
            $content = $this->twigEnvironment->render('packagist/default.html.twig', [
                'items' => $collection,
                'searchTerm' => $searchTerm,
            ]);
        } catch (\Exception $exception) {
            //TODO
        }

        $psr17Factory = new Psr17Factory();
        $responseBody = $psr17Factory->createStream($content);

        return $psr17Factory->createResponse(200)->withBody($responseBody);
    }
}
