<?php

namespace App\Http\Controllers\Apis;

use App\Exceptions\ForbiddenException;
use App\Exceptions\ValidatorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginGoogleRequest;
use App\Services\AuthenticatePassport\Actions\LoginAction;
use App\Services\Authenticate\Actions\LogoutAction;
use App\Services\AuthenticatePassport\Actions\LoginGoogleAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;
use Illuminate\Support\Facades\Http;

class AuthenticateController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api', ['except' => ['login','loginGoogle']]);
    }

    /**
     * Login manager
     *
     * @param Request $request Request
     *
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/auth",
     *     tags={"Auth"},
     *     summary="User login",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "password"},
     *               @OA\Property(property="email", type="text"),
     *               @OA\Property(property="password", type="password"),
     *            ),
     *        ),
     *    ),
     *     @OA\Response(response="200", description="User login successfully"),
     *     @OA\Response(response="422", description="Validation errors"),
     *     @OA\Response(response="500", description="User login fail")
     * )
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->only([
                'email',
                'password',
            ]);

            $response = resolve(LoginAction::class)->run($credentials);
        } catch (ValidatorException $ex) {
            return $this->responseError(trans('auth.failed'), $ex->getMessageBag(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (ForbiddenException $ex) {
            return $this->responseError($ex->getMessage(), $ex->getData() ?? [], Response::HTTP_FORBIDDEN);
        } catch (JWTException $ex) {
            // something went wrong whilst attempting to encode the token
            return $this->responseError(trans('auth.failed'));
        } catch (Exception $ex) {
            return $this->responseError(trans('auth.failed'));
        }

        return $this->responseSuccess(trans('auth.login.success'), $response);
    }

    /**
     * Logout
     *
     * @return JsonResponse
     * 
     * * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Auth"},
     *     summary="User logout",
     *     @OA\Response(response="200", description="User logout successfully"),
     *     @OA\Response(response="500", description="User logout fail")
     * )
     */
    public function logout()
    {
        try {
            $response = resolve(LogoutAction::class)->run();
        } catch (ForbiddenException $ex) {
            return $this->responseError($ex->getMessage(), $ex->getData() ?? [], Response::HTTP_FORBIDDEN);
        } catch (Exception $ex) {
            return $this->responseError(trans('auth.logout.failed'));
        }

        return $this->responseSuccess(trans('auth.logout.success'), $response);
    }

    public function loginGoogle(UserLoginGoogleRequest $request)
    {
        try {
            $input = $request->validated();
            $response = resolve(LoginGoogleAction::class)->run($input['token'] ?? '');

            return $this->responseSuccess(trans('auth.login.success'), $response);

        } catch (ForbiddenException $ex) {
            return $this->responseError($ex->getMessage(), $ex->getData() ?? [], Response::HTTP_FORBIDDEN);
        } catch (Exception $ex) {
            return $this->responseError(trans('auth.failed'));
        }
    }
}
