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
     * 
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"Auth"},
     *     summary="User Register",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name", "email", "password", "password_confirm"},
     *               @OA\Property(property="name", type="text"),
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="password", type="password"),
     *               @OA\Property(property="password_confirm", type="password"),
     *            ),
     *        ),
     *    ),
     *     @OA\Response(response="200", description="User register successfully"),
     *     @OA\Response(response="422", description="Validation errors"),
     *     @OA\Response(response="500", description="User register fail")
     * )
     * 
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
     * 
     * @OA\Get(
     *   path="/api/users/delete/{id}",
     *   tags={"User"},
     *   summary="Delete user",
     *   @OA\Parameter(
     *         description="User ID",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *    ),
     *   @OA\Response(response=200, description="Delete user successfully"),
     *   @OA\Response(response=500, description="Delete user fail")
     * )
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
     *
     * @OA\Get(
     *   path="/api/users/show/{id}",
     *   tags={"User"},
     *   summary="Show user",
     *   @OA\Parameter(
     *         description="User ID",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *    ),
     *   @OA\Response(response=200, description="Get user info successfully"),
     *   @OA\Response(response=500, description="Get user info fail"),
     *   @OA\Response(response=404, description="User not found")
     * )
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
