<?php namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use App\User;
use Lang;
use App\Field;

trait AuthenticatesAndRegistersUsers {

	/**
	 * The Guard implementation.
	 *
	 * @var \Illuminate\Contracts\Auth\Guard
	 */
	protected $auth;

	/**
	 * The registrar implementation.
	 *
	 * @var \Illuminate\Contracts\Auth\Registrar
	 */
	protected $registrar;

	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getRegister()
	{
		// get the traslations of the current locale
		$translations = get_parking_translation( 'NULL' );
		//dd($translations);
		$title_attributes = NULL;
		foreach ($translations as $key2 => $value2) {
			if ($key2 == 'title'){
				$title_attributes = $value2['attributes'];
				$translations['title'] = $value2['value'];
			}
		}

		if (empty($title_attributes)){
			$field = Field::where('field_name', '=', 'title')->first();
			$titles = json_decode($field->attributes, true);
		}
		else
			$titles = json_decode($title_attributes, true);

		return view('auth.register', compact('titles'));
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
		$validator = $this->registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$activation_code = str_random(60) . $request->input('email');
		$user = new User;
		$user->title = $request->input('title');
		$user->firstname = $request->input('firstname');
		$user->lastname = $request->input('lastname');
		$user->mobile = $request->input('mobile');
		$user->email = $request->input('email');
		$user->password = bcrypt($request->input('password'));
		$user->activation_code = $activation_code;
		$user->newsletter = $request->input('newsletter');

		if ($user->save()) {
			$data = array(
				'email' => $user->email,
				'code' => $activation_code,
				'link' => 'http://www.parkinglegend.com/activate/'.$activation_code
			);
			//\Mail::queue('emails.activation', $data, function($message) use ($user) {
			\Mail::later(15, 'emails.activation', $data, function($message) use ($user) {
				$message->to($user->email, 'Please activate your account.')->subject(Lang::get('emails.reg_act_subject'));
			});
			//return view('user.activateAccount');
			\Session::flash('message', Lang::get('emails.reg_act_activation'));
			return redirect('/');
		}
		else {
			\Session::flash('message', 'Your account couldn\'t be create please try again');
			return redirect()->back()->withInput();
		}

		$this->auth->login($this->registrar->create($request->all()));

		return redirect($this->redirectPath());
	}

	/**
	 * Show the application login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogin()
	{
		return view('auth.login');
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email', 'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			return redirect()->intended($this->redirectPath());
		}

		return redirect($this->loginPath())
					->withInput($request->only('email', 'remember'))
					->withErrors([
						'email' => $this->getFailedLoginMessage(),
					]);
	}

	/**
	 * Get the failed login message.
	 *
	 * @return string
	 */
	protected function getFailedLoginMessage()
	{
		return 'These credentials do not match our records.';
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogout()
	{
		$this->auth->logout();

		return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
	}

	/**
	 * Get the post register / login redirect path.
	 *
	 * @return string
	 */
	public function redirectPath()
	{
		if (property_exists($this, 'redirectPath'))
		{
			return $this->redirectPath;
		}

		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
	}

	/**
	 * Get the path to the login route.
	 *
	 * @return string
	 */
	public function loginPath()
	{
		return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
	}

}