<?php

/**
 * @SWG\Swagger(
 *     basePath="/api",
 *     schemes={"http", "https"},
 *     host="http://localhost",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Login com JWT",
 *         description="Sistema de login utilizando JWT",
 *         @SWG\Contact(
 *             email="darius@matulionis.lt"
 *         ),
 *     )
 * )
 */

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * @SWG\Post(
     *      path="/auth",
     *      operationId="PostauthList",
     *      tags={"Auth"},
     *      summary="Post list of auth",
     *      description="Returns list of auth",
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @SWG\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of auth
     */

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $credentials = $this->credentials($request);

        $token = \JWTAuth::attempt($credentials);

        return $this->responseToken($token);
    }

    /**
     * @SWG\Post(
     *      path="/auth/{id}",
     *      operationId="PostProjectById",
     *      tags={"Auth"},
     *      summary="Post project information",
     *      description="Returns project data",
     *      @SWG\Parameter(
     *          name="id",
     *          description="Project id",
     *          required=true,
     *          type="integer",
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @SWG\Response(response=400, description="Bad request"),
     *      @SWG\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:auth", "read:auth"}
     *         }
     *     },
     * )
     *
     */

    private function responseToken($token)
    {
        return $token ? ['token' => $token] : response()->json([
            'error' => \Lang::Post('auth.failed')
        ], 400);
    }

    public function logout()
    {
        \Auth::guard('api')->logout();
        return response()->json([], 204);
    }

    public function refresh()
    {
        $token = \Auth::guard('api')->refresh();
        return ['token' => $token];
    }
}
