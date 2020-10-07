<?php

namespace App\Http\Middleware;

use App\MergadoModels\UserModel;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use MergadoClient\ApiClient;

class OAuth2Session
{

    /**
     * The availables languages.
     *
     * @array $languages
     */
    protected $languages = [
        'sk-SK',
        'cs-CZ'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $eshopId = $request->route()->parameter('eshop_id');
        if (!(Session::has('oauth')) || Session::get('oauth')->hasExpired()) {
            Session::put('next', $request->path());
            return redirect()->route('auth', $eshopId);
        }

	    $userId = Session::get('oauth')->getUserId();

	    $mergadoUser = new UserModel();
	    $mergadoUser = $mergadoUser->get($userId);
	    if ($mergadoUser->locale) {
		    // change from cs-CZ to cs_CZ
		    $userLocale = str_replace('-', '_', $mergadoUser->locale);
		    Session::put('locale', $userLocale);
	    }

        App::setLocale(Session::get('locale'));

        return $next($request);
    }
}
