<?php

namespace App\Models\Clients;

use App\Traits\ActiveTrait;
use App\Traits\AuthorTrait;
use App\Traits\ClientTrait;
use App\Traits\CommonTrait;
use App\Traits\SensorTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
	use SoftDeletes;
	use CommonTrait;
	use ActiveTrait;
	use AuthorTrait;
	use ClientTrait;
	public $timestamps = true;
	protected $fillable = [
		'author_id',
		'client_id',
		'name',
		'content',
		'active',
	];


	public function getMapList() {
		return [
			'entity'          => 'devices',
			'id'              => $this->getAttribute('id'),
			'name'            => $this->getShortName(),
			'author'          => $this->getShortAuthorName(),
			'short_content'   => $this->getShortContent(),
			'n_sensors'       => $this->getSensorsCount(),
			'created_at'      => $this->getCreatedAtFormatted(),
			'created_at_time' => $this->getCreatedAtTime(),
			'active'          => $this->getActiveFullResponse()
		];
	}

	static public function getAlltoSelectList()
	{
		return self::get()->map(function ($s) {
			return [
				'id' => $s->id,
				'description' => $s->getShortName()
			];
		})->pluck('description', 'id');
	}

	public function getName()
	{
		return $this->getAttribute('name');
	}

	public function getShortName()
	{
		return str_limit($this->getAttribute('name'), 20);
	}

	public function getShortContent()
	{
		return str_limit($this->getAttribute('content'), 50);
	}

	public function getSensorsCount()
	{
		return $this->sensors->count();
	}

	// ******************** RELASHIONSHIP ******************************

	public function sensors()
	{
		return $this->hasMany(Sensor::class, 'device_id');
	}
}