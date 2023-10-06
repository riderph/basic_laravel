<?php

namespace App\Http\Controllers\Apis;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->user()->cannot('create', Post::class));
        if ($request->user()->cannot('create', Post::class)) {
            return $this->responseError(trans('post.index.failed'), "error");
        }
        return $this->responseSuccess(trans('post.index.success'), []);
    }
}
