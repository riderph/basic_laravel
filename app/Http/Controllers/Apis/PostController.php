<?php

namespace App\Http\Controllers\Apis;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        return $this->responseSuccess(trans('post.index.success'), []);
    }
}
