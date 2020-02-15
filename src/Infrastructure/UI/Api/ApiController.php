<?php
declare(strict_types=1);

namespace OpenEMR\Modules\DemoFarmAddOns\Infrastructure\UI\Api;

use Symfony\Component\HttpFoundation\Response;

class ApiController
{
    public function __invoke(): Response
    {
        $data = [
            'foo' => 'foo',
            'bar' => 'bar'
        ];

        $response = new Response(
            json_encode(['result' => $data]),
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );


        return $response;
    }
}
