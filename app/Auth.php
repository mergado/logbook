<?php

namespace App;

use App\MergadoModels\UserModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use MergadoClient\OAuth2\MergadoProvider;

class Auth {


	public static function getMergadoProvider () {
		$provider  = new MergadoProvider([
				'clientId'                => env('CLIENT_ID'),    // The client ID assigned to you by the provider
				'clientSecret'            => env('CLIENT_SECRET'),   // The client password assigned to you by the provider
				'redirectUri'             => env('REDIRECT_URI')
		], [], env('MODE'));

		return $provider;
	}

	public function __construct() {
		$this->provider = $this->getMergadoProvider();
	}

	public function getAuthCode($eshopId){

		$authorizationUrl = $this->provider->getAuthorizationUrl(['entity_id' => $eshopId]);

		// Get the state generated for you and store it to the session.
		Session::put('oauth2state', $this->provider->getState());

		return redirect($authorizationUrl);

	}

	// SessionManager will be used instead (we don't need to redirect here, we can do redirect to authorization url directly from session manager function
	public function getAuthUrl(){

		$authorizationUrl = $this->provider->getAuthorizationUrl();

		return $authorizationUrl;

	}

	public function getToken(Request $request){

		try {

			// Try to get an access token using the authorization code grant.
			$accessToken = $this->provider->getAccessToken('authorization_code', [
					'code' => $request->input("code")
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