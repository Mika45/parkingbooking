<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App;

class AuthenticateAdmin {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ( $this->auth->guest() or $this->auth->user()->is_admin != 'Y' )
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				//return redirect()->guest('auth/login');
				App::abort(403, 'Unauthorized');
			}
		}
		
		return $next($request);
	}

}