<?php
/**
 * Created by PhpStorm.
 * User: samuel
 * Date: 23.2.16
 * Time: 9:30
 */

namespace App\MergadoModels;


class ProjectModel  extends MergadoApiModel {


	public function get($projectId) {
		return $this->api->projects($projectId)->get();
	}


}