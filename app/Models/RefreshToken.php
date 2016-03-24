<?php

namespace App;

use App\MergadoModels\EshopModel;
use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{

	public $timestamps = false;
	protected $table = 'refresh_tokens';
	protected $fillable = [
		'id',
		'user_id',
		'eshop_id',
		'expire_time'
	];

	public function user() {
		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function projects() {
		$eshopModel = new EshopModel();
		return $eshopModel->getProjects($this->eshop_id);
	}
}
