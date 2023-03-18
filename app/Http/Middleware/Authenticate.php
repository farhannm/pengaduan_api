<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
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
    //     if ($this->auth->guard($guard)->guest()) {
    //         return response('Anda Tidak Memiliki Otoritas.', 401);
    //     }
        if ($request->header('authorization')) {
            $data =  User::where('api_token', $request->header('authorization'))->first();
            if($data == null){
                return response('Anda Tidak Memiliki Otoritas.', 401);
            }
        } else {
            return response('Anda Tidak Memiliki Otoritas.', 401);
        }

        return $next($request);
    }
}
