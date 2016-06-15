<?php

namespace App\MergadoModels;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use JsonSerializable;
use MergadoClient\ApiClient;

abstract class MergadoApiModel
//    implements ArrayAccess, Arrayable, Jsonable, JsonSerializable
{

	protected $api;
	const NEED_ID = true;

//	protected

	public function __construct($attributes = [], $token = null)
	{
		if($attributes) {
			$this->populate($attributes);
		}

		if($token){
			$this->api = new ApiClient($token, env('MODE'));
		} elseif (Session::get("oauth")) {
			$this->api = new ApiClient(Session::get('oauth')->getToken(), env('MODE'));
		} else {
			$this->api = null;
		}

	}

	public function setToken($token) {
		if($this->api) {
			$this->api->setToken($token);
		} else {
			$this->api = new ApiClient($token, env('MODE'));
		}
	}

	public static function apiClient() {
		return new ApiClient(Session::get('oauth')->getToken(), env('MODE'));
	}

	protected function getPublicProperties()
	{
		$props = (new \ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC);
		$returnArray = [];
		foreach ($props as $prop) {
			array_push($returnArray, $prop->name);
		}
		return $returnArray;
	}

	public static function hydrate($collection = [])
	{
		$type = gettype($collection);
		$returnArray = [];

		if ($type == "object") {
			$collection = (array) $collection;
		} elseif (!$type == "array") {
			return $returnArray;
		}

		if (static::NEED_ID) {
			foreach ($collection as $atributes) {
				$instance = new static($atributes->id, $atributes);
				array_push($returnArray, $instance);
			}
		} else {
			foreach ($collection as $atributes) {
				$instance = new static($atributes);
				array_push($returnArray, $instance);
			}
		}

		return $returnArray;
	}

	protected function populate($atributes)
	{
		$type = gettype($atributes);

		if ($type == "object") {
			$atributes = (array) $atributes;
		} elseif (!$type == "array") {
			return $this;
		}

		foreach ($atributes as $key => $value) {
			$this->setAttribute($key, $value);
		}

		return $this;
	}

	/**
	 * Get the fillable attributes of a given array.
	 *
	 * @param  array $attributes
	 * @return array
	 */
	protected function fillableFromArray(array $attributes)
	{

		$properties = static::getPublicProperties();
		return array_intersect_key($attributes, array_flip($properties));

	}

	/**
	 * Determine if a set mutator exists for an attribute.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function hasSetMutator($key)
	{
		return method_exists($this, 'set'.$this->camelCase($key));
	}

	protected function camelCase($string) {
		$value = ucwords(str_replace(['-', '_'], ' ', $string));

		return str_replace(' ', '', $value);
	}

	/**
	 * Set a given attribute on the model.
	 *
	 * @param  string  $key
	 * @param  mixed  $value
	 * @return $this
	 */
	public function setAttribute($key, $value)
	{
		// First we will check for the presence of a mutator for the set operation
		// which simply lets the developers tweak the attribute as it is set on
		// the model, such as "json_encoding" an listing of data for storage.
		if ($this->hasSetMutator($key)) {
			$method = 'set'.$this->camelCase($key).'Attribute';

			return $this->{$method}($value);
		}

		$this->{$key} = $value;

		return $this;
	}

	public function stripNullProperties() {
		$object = (object) array_filter((array) $this, function ($val) {
			return !is_null($val);
		});

		return $object;
	}

}