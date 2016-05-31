<?php

namespace App\Http\Controllers;

use App\Auth;
use App\FailLog;
use App\Http\Requests;
use Illuminate\Http\Request;
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
                        return redirect()->route('error', ['message' => trans('error.invalid-entity')]);
                        break;
                    case 'user_permission_error':
                        return redirect()->route('error', ['message' => trans('error.user_permission_error')]);
                        break;
                    case (preg_match('/invalid_request.*/', $error) ? true : false) :
                        return redirect()->route('error', ['message' => trans('error.oauth_invalid_request')]);
                        break;
                }

                FailLog::create([
                    "message" => $error . " occured when trying to authorize"
                ]);

                return redirect()->route('error');
            } else {

                FailLog::create([
                    "message" => $error . " occured and application will try to authorize again."
                ]);

                Session::put('oauthError', true);
                return $this->oauth->getAuthCode(Session::get('entity_id'));
            }

        }

    }

}
