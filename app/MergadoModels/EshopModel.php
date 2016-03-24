<?php
/**
 * Created by PhpStorm.
 * User: samuel
 * Date: 23.2.16
 * Time: 9:32
 */

namespace App\MergadoModels;


class EshopModel extends MergadoApiModel {

	public function get($eshopId) {
		return $this->api->shops($eshopId)->get();
	}

	public function getProjects($eshopId) {
		return $this->api->shops($eshopId)->projects->get();
	}

	public function query($eshopId) {
		return $this->api->shops($eshopId);
	}

}