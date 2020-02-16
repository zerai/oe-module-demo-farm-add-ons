<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Web;

use Symfony\Component\HttpFoundation\Response;

class TwigController
{
    use TwigTrait;

    public function __invoke(): Response
    {
        $response = new Response(
            $this->render('base.html.twig', []),
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );

        return $response;
    }
}
