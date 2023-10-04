<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;
use Exception;
use Illuminate\Http\Response;

class Authenticate extends Middleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);

            return $next($request);
        } catch (AuthenticationException $ex) {
            return response()->json([
                'status_code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Token invalid',
                'errors' => []
            ], Response::HTTP_UNAUTHORIZED);
        } catch (Exception $ex) {
            return response()->json([
                'status_code' => Response::HTTP_SERVICE_UNAVAILABLE,
                'message' => 'Service unavailable.',
                'errors' => []
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : 'login';
    }
}
