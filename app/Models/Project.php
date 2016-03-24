<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{

	public $timestamps = false;

	public function eshop() {
		return $this->belongsTo('App\Models\Eshop');
	}

	public function logs() {
		return $this->hasMany('App\Models\Log', 'project_id');
	}

}
