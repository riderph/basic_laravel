<?php

namespace App\Http\Controllers\Apis;

use App\Exceptions\ForbiddenException;
use App\Exceptions\ValidatorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Services\User\Actions\DeleteAction;
use App\Services\User\Actions\RegisterAction;
use App\Services\User\Actions\ShowAction;
use App\Services\User\Actions\UpdateAction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class UserController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth:api', ['except' => ['register']]);
    }

    /**
     * Login manager
     *
     * @param Request $request Request
     *
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $credentials = $request->only([
                'name',
                'email',
                'password',
                'password_confirm',
            ]);

            $response = resolve(RegisterAction::class)->run($credentials);
        } catch (ValidatorException $ex) {
            return $this->responseError(trans('auth.register.failed'), $ex->getMessageBag(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (ForbiddenException $ex) {
            return $this->responseError($ex->getMessage(), $ex->getData() ?? [], Response::HTTP_FORBIDDEN);
        } catch (Exception $ex) {
            return $this->responseError(trans('auth.register.failed'));
        }

        return $this->responseSuccess(trans('auth.register.success'), $response);
    }

    /**
     * Login manager
     *
     * @param int $id Id user was delete
     *
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        try {
            $response = resolve(DeleteAction::class)->run($id);
        } catch (ModelNotFoundException $ex) {
            return $this->responseError($ex);
        } catch (Exception $ex) {
            return $this->responseError(trans('auth.register.failed'));
        }

        return $this->responseSuccess(trans('auth.delete.success'), $response);
    }

    /**
     * Login manager
     *
     * @param int $id Id user was delete
     *
     * @return JsonResponse
     */
    public function show(int $id)
    {
        try {
            $response = resolve(ShowAction::class)->run($id);
        } catch (ModelNotFoundException $ex) {
            return $this->responseError($ex);
        } catch (Exception $ex) {
            return $this->responseError(trans('auth.show.failed'));
        }

        return $this->responseSuccess(trans('auth.show.success'), $response);
    }

    /**
     * Update user
     *
     * @param UpdateUserRequest $request Request
     * @param int               $id      Id user need to update
     *
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        try {
            $data = $request->only([
                'name',
                'email',
            ]);

            $response = resolve(UpdateAction::class)->run($id, $data);
        } catch (ModelNotFoundException $ex) {
            return $this->responseError($ex);
        } catch (Exception $ex) {
            return $this->responseError(trans('auth.register.failed'));
        }

        return $this->responseSuccess(trans('auth.register.success'), $response);
    }
}
