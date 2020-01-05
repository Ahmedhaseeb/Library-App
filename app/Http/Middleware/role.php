<?php

namespace App\Http\Middleware;
use Closure;
use App\Http\Controllers\userController;
class role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {

        $user = new userController();
        //echo $role;
        //die();
        if(!$user->allowed($request,$role)){
            return redirect("/403");
        }
        return $next($request);
    }
}
