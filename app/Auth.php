<?php

namespace App;

use App\MergadoModels\UserModel;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use MergadoClient\OAuth2\MergadoProvider;

class Auth {

	public function __construct() {
		$this->provider = new MergadoProvider([
				'clientId'                => env('CLIENT_ID'),    // The client ID assigned to you by the provider
				'clientSecret'            => env('CLIENT_SECRET'),   // The client password assigned to you by the provider
				'redirectUri'             => env('REDIRECT_URI')
		], [], env('MODE'));
	}

	public function getAuthCode($eshopId){

		$authorizationUrl = $this->provider->getAuthorizationUrl(['entity_id' => $eshopId]);

		// Get the state generated for you and store it to the session.
		Session::put('oauth2state', $this->provider->getState());

		return redirect($authorizationUrl);

	}

	public function getAuthUrl(){

		$authorizationUrl = $this->provider->getAuthorizationUrl();

		// Get the state generated for you and store it to the session.
		Session::put('oauth2state', $this->provider->getState());

		return $authorizationUrl;

	}

	public function getToken(){

		try {
			//CSRF protection
			if ($_GET['state'] !== Session::get('oauth2state')) {
				// throw exception or redirect to error page
				return redirect()->route('error');
			};

			// Try to get an access token using the authorization code grant.
			$accessToken = $this->provider->getAccessToken('authorization_code', [
					'code' => $_GET['code']
			]);

			Session::put('oauth', $accessToken);

			$megadoUser = new UserModel();
			$megadoUser = $megadoUser->get($accessToken->getResourceOwnerId());

			$user = [
				'email' => $megadoUser->email,
				'first_name' => $megadoUser->first_name,
				'last_name' => $megadoUser->last_name,
				'name' => $megadoUser->name,
				'locale' => $megadoUser->locale
			];
			$user = User::updateOrCreate(['id' => $megadoUser->id], $user);

			Session::forget('oauth2state');

			if(Session::has('next')) {
				$next = Session::get('next');
				Session::forget('next');
				return redirect($next);
			}

			return redirect(Session::get('_previous')['url']);

		} catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

			// Your exception handling
			var_dump($e);

		}
	}

}