<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Generator;

class SwaggerController extends Controller
{
    /**
     * Generate API documentation.
     *
     * @return mixed
     */
    public function __invoke()
    {
        $openapi = Generator::scan(['/app']);

        header('Content-Type: application/x-yaml');
        echo $openapi->toYaml();
    }
}
