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


            <script>
                // Fax and SMS status
                function retrieveMsgs(e = '', req = '') {
                    top.restoreSession();
                    if (e) {
                        e.preventDefault();
                    }
                    let actionUrl = 'getPending';
                    let id = pid;
                    let datefrom = $('#fromdate').val();
                    let dateto = $('#todate').val();
                    let data = [];

                    $("#brand").append(wait);
                    $("#rcvdetails tbody").empty();
                    $("#sentdetails tbody").empty();
                    $("#msgdetails tbody").empty();
                    return $.post(actionUrl,
                        {
                            'pid': pid,
                            'datefrom': datefrom,
                            'dateto': dateto
                        }, function () {
                        }, 'json').done(function (data) {
                        if (data.error) {
                            $("#wait").remove();
                            var err = (data.error.search(/Exception/) !== -1 ? 1 : 0);
                            if (!err) {
                                err = (data.error.search(/Error:/) !== -1 ? 1 : 0);
                            }
                            if (err) {
                                alertMsg(data.error);
                            }
                            return false;
                        }
                        // populate our panels
                        $("#rcvdetails tbody").empty().append(data[0]);
                        $("#sentdetails tbody").empty().append(data[1]);
                        $("#msgdetails tbody").empty().append(data[2]);
                        // get call logs
                        getLogs();
                    }).fail(function (xhr, status, error) {
                        alertMsg(<?php echo xlj('Not Authenticated. Restart from Modules menu or ensure credentials are setup from Activity menu.') ?>, 5000)
                    }).always(function () {
                        $("#wait").remove();
                    });
                }
            </script>
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
