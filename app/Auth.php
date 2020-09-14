<?php

namespace App;

use App\Exceptions\SessionException;
use App\MergadoModels\UserModel;
use App\Models\OfflineToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use MergadoClient\OAuth2\MergadoProvider;

class Auth
{
    public $provider;

    public static function getMergadoProvider()
    {
        $provider = new MergadoProvider([
            'clientId' => env('CLIENT_ID'),    // The client ID assigned to you by the provider
            'clientSecret' => env('CLIENT_SECRET'),   // The client password assigned to you by the provider
            'redirectUri' => env('REDIRECT_URI'),
            'oAuthEndpoint' => env('MERGADO_OAUTH_ENDPOINT'),
        ], []);

        return $provider;
    }

    public function __construct()
    {
        $this->provider = $this->getMergadoProvider();
    }

    public function getAuthCode($eshopId)
    {
        return redirect($this->getAuthUrl($eshopId));
    }

    // SessionManager will be used instead (we don't need to redirect here, we can do redirect to authorization url directly from session manager function
    public function getAuthUrl($eshopId)
    {
        $authorizationUrl = $this->provider->getAuthorizationUrl(['entity_id' => $eshopId]);
        return $authorizationUrl;
    }

    public function getToken(Request $request)
    {
        // Try to get an access token using the authorization code grant.
		$accessToken = $this->provider->getAccessToken('authorization_code', [
			'code' => $request->input("code")
		]);

        Session::put('oauth', $accessToken);
        $userId = $accessToken->getUserId();

        // Load User data from mergado
        $megadoUser = new UserModel();
        $megadoUser = $megadoUser->get($userId);
        $user = [
            'email' => $megadoUser->email,
            'first_name' => $megadoUser->first_name,
            'last_name' => $megadoUser->last_name,
            'name' => $megadoUser->name,
            'locale' => $megadoUser->locale,
            'updated_at' => new \DateTime(),
        ];
        User::updateOrCreate(['id' => $megadoUser->id], $user);

        if (Session::has('next')) {
            $next = Session::get('next');
            Session::forget('next');
            return redirect($next);
        }

        $previous = Session::get('_previous')['url'];
        if (!$previous) {
            throw new SessionException("Session has no previous on oauth redirect uri route.");
        }

        return redirect($previous);
    }

    public function getOfflineToken($entityId, $forceNew = true)
    {

        if (!$forceNew) {
            $offlineToken = OfflineToken::getValidAccessToken($entityId);

            if($offlineToken) return $offlineToken;
        }
        $offlineToken = $this->provider->getAccessToken('refresh_token', [
            'entity_id' => $entityId
        ]);

        OfflineToken::updateOrCreate(["eshop_id" => $entityId], [
            "token" => $offlineToken->getToken(),
            "eshop_id" => $entityId,
            "expire_time" => $offlineToken->getExpires()
        ]);

        return $offlineToken;
    }

}
