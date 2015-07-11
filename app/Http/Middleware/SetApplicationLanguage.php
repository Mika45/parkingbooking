<?php namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class SetApplicationLanguage {

  /**
  * Handle an incoming request.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \Closure  $next
  * @return mixed
  */

  public function handle($request, Closure $next)
  {
    Session::keep(['allowedParkings']); // added because of the session expiration when changing the language

    if (Session::has('applocale') AND array_key_exists(Session::get('applocale'), Config::get('app.locales'))) {
        App::setLocale(Session::get('applocale'));
    }
    else {
        App::setLocale(Config::get('app.fallback_locale'));
    }
      
    return $next($request);
  }

}