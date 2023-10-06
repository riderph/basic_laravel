<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;

class DemoPostPolicyMiddleware
{
    protected $auth;

    public function __construct(Guard $auth){
        $this->auth = auth('api')->user();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permissions
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = '')
    {
        if (empty($this->auth)) {
            return response()->json([
                'status_code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Forbidden',
                'errors' => []
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        if ($this->auth->cannot($permission, Post::class)) {
            return response()->json([
                'status_code' => Response::HTTP_FORBIDDEN,
                'message' => 'Forbidden',
                'errors' => []
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
