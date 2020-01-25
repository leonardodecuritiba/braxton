<?php

namespace App\Models\Commons;

use App\Models\Clients\Sensor;
use App\Traits\ActiveTrait;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SensorType extends Model
{
	use SoftDeletes;
	use ActiveTrait;
	use CommonTrait;
	public $timestamps = true;
	protected $fillable = [
		'code',
		'description',
		'scale',
		'scale_name',
		'range',
		'type',
		'active',
	];

	static public function getAllActiveToSelectList()
	{
		return self::active()->get()->map(function ($s) {
			return [
				'id' => $s->id,
				'description' => $s->getShortName()
			];
		})->pluck('description', 'id');
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

	public function getScaleText()
	{
		return $this->getAttribute('scale');
	}
	public function getName()
	{
		return $this->getAttribute('description') . ' (' . $this->getAttribute('scale') . ')';
	}

	public function setRangeAttribute($value)
	{
		return $this->attributes['range'] = json_encode($value);
	}

	public function getRange()
	{
		return json_decode($this->getAttribute('range'));
	}

	public function getRangeValues()
	{
		$range = $this->getRange();
		return [
			'min'       => $range[0],
			'max'       => $range[1],
			'mid'       => round(($range[0] + $range[1])/2),
			'midmid'    => round(($range[0] + $range[1])/4),
			'step'      => $this->getStep(),
			'type'      => $this->getType(),
			'decimals'  => $this->getDecimals(),
		];
	}

	public function getMinValue()
	{
		$range = $this->getRange();
		return $range[0];
	}

	public function getMaxValue()
	{
		$range = $this->getRange();
		return $range[1];
	}

	public function getDecimals()
	{
		return $this->getAttribute('type') ? 0 : 1;
	}

	public function getStep()
	{
		return $this->getAttribute('type') ? 1 : 0.1;
	}

	public function getType()
	{
		return $this->getAttribute('type') ? 'int' : 'float';
	}

	public function getRangeText()
	{
		$range = $this->getRange();
		return 'min: '. $range[0].'; máx: '.$range[1];
	}

	public function getShortName()
	{
		return $this->getAttribute('description') . ' (' . $this->getAttribute('scale') . ')';
	}

	public function getSensorsCount()
	{
		return $this->sensors->count();
	}

	// ******************** RELASHIONSHIP ******************************
	public function sensors()
	{
		return $this->hasMany(Sensor::class, 'sensor_type_id');
	}
}