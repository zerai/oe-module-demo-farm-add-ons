<?php
declare(strict_types=1);


require_once __DIR__ . '/../../../../vendor/autoload.php';
//require_once(__DIR__ . "/../../../globals.php");

//use OpenEMR\Core\Header;


?>

    <!DOCTYPE html>
    <html>
    <head>
        <title><?php echo xlt('Demo Farm Add-ons Module'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php Header::setupHeader(); ?>
    </head>
    <body>
    <div class="container-fluid main-container" style="margin-top:50px">
        <div class="col-md-10 col-md-offset-1 content">
            <h3>
                <?php echo xlt("Available modules") ?>
                <small class="text-muted">- source: (packagist.org)</small>
            </h3>
            <?php
            /** @var PackagistItemCollection $collection */
            ?>

    </body>
    </html>



