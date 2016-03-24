<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

	protected $fillable = [
		'user_id',
		'date',
		'project_id',
		'body',
		'eshop_id'
	];

	public function user() {
		return $this->belongsTo('App\Models\User');
	}
}
