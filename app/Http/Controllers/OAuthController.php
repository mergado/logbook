<?php

namespace App\Http\Controllers;

use App\Auth;
use App\Exceptions\AuthorizationException;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
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

    public function token(Request $request)
    {

        if ($request->has('code')) {
            //request token
            return $this->oauth->getToken($request);
        } else if ($request->has('error')) {
            //error page / try again
            $error = $request->input('error');

            if (Session::has('oauthError') || !Session::has('entity_id')) {
                Session::forget('oauthError');

                switch ($error) {
                    case 'invalid_entity':
                        throw new AuthorizationException(trans('error.invalid-entity'));
                    case 'user_permission_error':
                        throw new AuthorizationException(trans('error.user_permission_error'));
                    case (preg_match('/invalid_request.*/', $error) ? true : false) :
                        throw new AuthorizationException(trans('error.oauth_invalid_request'));
                }

                return redirect()->route('error');
            } else {
                Log::notice($error . " occured and application is going to try to authorize again.");

                Session::put('oauthError', true);
                return $this->oauth->getAuthCode(Session::get('entity_id'));
            }

        }

    }

}
