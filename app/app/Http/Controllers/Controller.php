<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Yiisoft\Access\AccessCheckerInterface;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API documentation for blog example.",
 *     description="Implementation of Swagger with in Laravel",
 *     @OA\Contact(
 *         email="sergmoro1@ya.ru"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://mit-license.org/"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8080",
 *     description="Blog API Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="basicAuth",
 *     in="header",
 *     name="Authorization",
 *     type="http",
 *     description="Basic authentication by email & password.",
 *     scheme="basic"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $accessChecker;

    public function __construct(AccessCheckerInterface $accessChecker)
    { 
        $this->accessChecker = $accessChecker;
    }

    /**
     * Prepare NotFound response.
     *
     * @return Illuminate\Http\JsonResponse
     */
    protected function responseNotFound(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Not found.', 
        ], 404);
    }

    /**
     * Checking the permission to perform the action.
     * 
     * @param string $action
     * @param array $params
     */
    protected function checkAccess(string $action, $params = [])
    {
        $userId = auth()->id();
        if (!$this->accessChecker->userHasPermission($userId, $action, $params)) {
            abort(403, 'Access denied');
        }
    }
}
