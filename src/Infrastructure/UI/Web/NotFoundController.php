<?php declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

class NotFoundController
{
    public function __invoke(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();
        $responseBody = $psr17Factory->createStream($this->content());

        return $psr17Factory->createResponse(200)->withBody($responseBody);
    }

    private function content(): string
    {
        return '
            <!DOCTYPE html>
                <html>
                <head>
                    <title>Demo Farm - Not Found</title>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    
                    
                </head>
                <body>
                    <div class="container-fluid main-container" style="margin-top:50px">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-md-offset-1 content">
                                <h3>
                                    404 Page Not Found.
                                    
                                </h3>
                                
                                <a href="/interface/modules/custom_modules/oe-module-demo-farm-add-ons/index.php">back to index</a>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
        ';
    }
}
