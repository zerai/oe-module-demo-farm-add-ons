<?php
declare(strict_types=1);

/**
 * @see pag. 15 - https://www.open-emr.org/wiki/images/6/61/ModuleInstaller-DeveloperGuide.pdf - custom module section.
 */

require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once(__DIR__ . "/../../../globals.php");

use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistItemCollection;
use OpenEMR\Modules\DemoFarmAddOns\Finder\PackagistModuleFinder;
use OpenEMR\Core\Header;

$client = HttpClientDiscovery::find();
$messageFactory = MessageFactoryDiscovery::find();


$moduleFinder = new PackagistModuleFinder($client);

?>

    <!DOCTYPE html>
    <html>
    <head>
        <title><?php echo xlt('Search form Attempt Demo Farm Add-ons Module'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php Header::setupHeader(); ?>
    </head>
    <body>
    <div class="container-fluid main-container" style="margin-top:50px">
        <div class="col-md-10 col-md-offset-1 content">
            <h3>
                <?php echo xlt("Search form") ?>
            </h3>
            <?php
            /** @var PackagistItemCollection $collection */
            //$collection = $moduleFinder->searchModule();
            //echo generateTable($collection->getItems());
            ?>

    </body>
    </html>


<?php
/**
 *
 *  HELPER METHODS - (move this functions in a separate file)
 *
 */




/**
 * @param array $items
 * @return string
 */

function generateTable(array $items): string
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
?>
