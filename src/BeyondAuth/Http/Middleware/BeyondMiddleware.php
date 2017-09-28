<?php

namespace Pribumi\BeyondAuth\Http\Middleware;

use Closure;
use Response;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

/**
 * Laravel Middleware.
 *
 * @version    1.0.0
 *
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 */
class BeyondMiddleware
{
    protected $auth;

    /**
     * AdminAccess constructor.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  \Illuminate\Contracts\Auth\Guard $guard
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return $request->json([
                    'auth' => [
                        'status' => ['code' => 401, 'message' => 'Please make sure your request has an Authorization header'],
                        'data' => null,
                    ],
                ], 401);
            }

            return Response::json([
                    'auth' => [
                        'status' => ['code' => 401, 'message' => 'Please make sure your request has an Authorization header'],
                        'data' => null,
                    ],
                ], 401);
        }

        return $next($request);
    }
}
