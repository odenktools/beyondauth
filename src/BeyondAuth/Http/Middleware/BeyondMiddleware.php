<?php

namespace Pribumi\BeyondAuth\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Response;

class BeyondMiddleware
{
    protected $auth;

    /**
     * AdminAccess constructor.
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
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return $request->json([
                    'auth' => array(
                        'status' => array('code' => 401, 'message' => 'Please make sure your request has an Authorization header'),
                        'data'   => null,
                    ),
                ], 401);

            } else {
                return Response::json([
                    'auth' => array(
                        'status' => array('code' => 401, 'message' => 'Please make sure your request has an Authorization header'),
                        'data'   => null,
                    ),
                ], 401);
            }
        }
        return $next($request);
    }
}
