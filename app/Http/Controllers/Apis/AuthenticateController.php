<?php

namespace App\Http\Controllers\Apis;

use App\Exceptions\ForbiddenException;
use App\Exceptions\ValidatorException;
use App\Http\Controllers\Controller;
use App\Services\Authenticate\Actions\LoginAction;
use App\Services\Authenticate\Actions\LogoutAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;

class AuthenticateController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Login manager
     *
     * @param Request $request Request
     *
     * @return JsonResponse
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
}
