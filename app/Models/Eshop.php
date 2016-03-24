<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eshop extends Model
{

	public $timestamps = false;

	public function projects() {
		return $this->hasMany('App\Models\Project', 'eshop_id');
	}
}
