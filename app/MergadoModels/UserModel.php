<?php
/**
 * Created by PhpStorm.
 * User: samuel
 * Date: 24.2.16
 * Time: 12:25
 */

namespace App\MergadoModels;


use Illuminate\Support\Facades\Session;

class UserModel extends MergadoApiModel {

	public function get($id = null) {
		return $this->api->users($id)->get();
	}

}