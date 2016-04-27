<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ErrorController extends Controller
{

	public function index() {
		$message = Input::get('message');
		if (is_null($message)) {
			$message = trans('error.default');
		}
		return view('errors.wrong')->with('message', $message);
	}

	public function notFound() {
		return view('errors.404');
	}

	public function widget() {
		return view('errors.widget');
	}

}
