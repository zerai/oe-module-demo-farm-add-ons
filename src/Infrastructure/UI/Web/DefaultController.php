<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use OpenEMR\Modules\DemoFarmAddOns\Finder\ModuleFinder;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistItemCollection;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistModuleFinder;
use OpenEMR\Core\Header;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistItem;

class DefaultController
{
    /** @var ModuleFinder */
    private $moduleFinder;

    /** @var HttpClient */
    private $httpClient;
    /**
     * DefaultController constructor.
     */
    public function __construct(?HttpClient $httpClient, ?ModuleFinder $moduleFinder)
    {
        $this->httpClient = $httpClient ?? $this->setUpHttpClient();

        $this->moduleFinder = $moduleFinder ?? $moduleFinder = new PackagistModuleFinder($this->httpClient);
    }

    public function __invoke(Request $request): Response
    {
        $response = new Response(
            $this->content(),
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );

        return $response;
    }


    private function setUpHttpClient(): HttpClient
    {
        $client = HttpClientDiscovery::find();
        $messageFactory = MessageFactoryDiscovery::find();
        return $client;
    }


    private function content(): string
    {
        /** how does it work? */
        Header::setupHeader();

        $content = '
            <!DOCTYPE html>
                <html>
                <head>
                    <title>Demo Farm - Default</title>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <?//php Header::setupHeader(); ?>
                </head>
                <body>
                <div class="container-fluid main-container" style="margin-top:50px">
                    <div class="col-md-10 col-md-offset-1 content">
                        <h3>
                            Available modules
                            <small class="text-muted">- source: (packagist.org)</small>
                        </h3>';

        $collection = $this->moduleFinder->searchModule();
        $content .= $this->generateTable($collection->getItems());

        $content .= '
                    </div>
                </div>
                </body>
                </html>
        ';

        return $content;
    }




    /**
     * @param array <PackagistItem> $items
     * @return string
     */

    private function generateTable(array $items): string
    {
        if (empty($items)) {
            return '<h2>No openEMR modules available.</h2>';
        }

        $table = '
    	<div class="table-responsive">
    	<table class="table table-bordered table-striped">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">Name</th>
		      <th scope="col">Url</th>
		      <th scope="col">Downloads</th>
		    </tr>
		  </thead>
		  <tbody>
	';

        foreach ($items as $key => $item) {
            $tableRow = sprintf('<tr><th scope="row">%s</th><td>%s</td><td><a href="%s" target="new">%s</a></td><td>%s</td></tr>', (string)((int) $key + 1), $item->getName(), $item->getUrl(), $item->getUrl(), (string) $item->getDownloads());
            $table .= $tableRow;
        }

        $table .='
		  </tbody>
		</table>
	    </div>
  ';

        return $table;
    }
}
