<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function handleResponse($result, string $message, int $code = Response::HTTP_OK, bool $success = true)
    {
        // Format response
        $response = [
            "success" => $success,
            "data"    => $result,
            "message" => $message
        ];
        // return response
        return response()->json($response, $code);
    }

    public function checkGate(string $permission)
    {
        if(Gate::denies($permission)) throw new UnauthorizedException('This action is unauthorized.', Response::HTTP_UNAUTHORIZED);
    }
}
