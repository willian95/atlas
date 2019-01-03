<?php namespace App\Http\Middleware;

use Closure;

class admin {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{	
		if(\Auth::check() && (\Auth::user()->role_id == 1 || \Auth::user()->role_id == 245 || \Auth::user()->role_id == 145 || \Auth::user()->role_id == 280 || \Auth::user()->role_id == 300)){

			return $next($request);
		}

		else{
			return redirect()->back()->with('alert', 'No tiene los permisos necesarios');
		}
	}

}
