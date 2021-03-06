<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /*if ($this->auth->guard($guard)->guest()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);*/
        if ($this->auth->guard($guard)->guest()) {
            if ($request->has('api_token')) {
                $token = $request['api_token'];
                $check_token = User::where('api_token', $token)->first();
                if ($check_token == null) {
                    $res = [
                        'success' => false,
                        'message' => 'Permission not allowed.'
                    ];
                    return response()->json($res);
                }
            } else {
                $res = [
                    'success' => false,
                    'message' => 'Login Please'
                ];
                return response()->json($res);
            }
        }
        return $next($request);
    }
}
