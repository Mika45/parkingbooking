<?php namespace App\Http\Middleware;

use Closure;

class RedirectUnsecure {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		//dd( url($request->_url, $parameters = [], $secure = false) );

		$request->_url = url($request->_url, $parameters = [], $secure = false);
		//$request->_url = 'http://www.google.com';
		//dd($request->getRequestUri());
		//return redirect($request->_url);

		//dd($request->_url);
		//if (fnmatch("*/contact*", $request->_url)){
			
		//}

		if ($request->secure() && env('APP_ENV') === 'prod') {
		//if (!$request->secure()) {
            return redirect(url($request->_url, $parameters = [], $secure = false));
        }

		return $next($request);
	}

}
