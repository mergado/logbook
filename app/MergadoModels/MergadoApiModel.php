<?php

namespace App\MergadoModels;


use Illuminate\Support\Facades\Session;
use MergadoClient\ApiClient;

abstract class MergadoApiModel {

	protected $api;

	public function __construct() {
		$this->api = new ApiClient(Session::get('oauth')->getToken(), env('MODE'));
	}

}