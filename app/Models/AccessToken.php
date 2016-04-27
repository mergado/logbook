<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{

	public $timestamps = false;
	protected $fillable = ['id', 'user_id', 'eshop_id', 'expire_time'];

	protected $table = 'access_tokens';

	public function user() {
		return $this->belongsTo('App\Models\User', 'user_id');
	}

}
