<?php

namespace App\Http\Controllers;

use App\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class OAuthController extends Controller
{
	private $oauth;

	public function __construct()
	{
		$this->oauth = new Auth();
	}

	public function auth($eshopId)
	{
		Session::put('entity_id', $eshopId);
		return $this->oauth->getAuthCode($eshopId);

	}

	public function token() {

		if(isset($_GET['error'])) {
			//error page / try again

			if(Session::has('oauthError') || !Session::has('entity_id')) {
				Session::forget('oauthError');
				$error = $_GET['error'];

				switch ($error) {
					case 'invalid_entity':
						return redirect()->route('error', ['message' => trans('error.invalid-entity')]);
						break;
					case 'user_permission_error':
						return redirect()->route('error', ['message' => trans('error.user_permission_error')]);
						break;
					case (preg_match('/invalid_request.*/', $error) ? true : false) :
						return redirect()->route('error', ['message' => trans('error.oauth_invalid_request')]);
						break;
				}

				return redirect()->route('error');
			} else {


				Session::put('oauthError',true);
				return $this->oauth->getAuthCode(Session::get('entity_id'));
			}

		} else if(isset($_GET['code'])) {
			//request token
			return $this->oauth->getToken();
		}

	}

}
