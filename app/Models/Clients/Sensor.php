<?php

namespace App\Models\Clients;

use App\Helpers\BaseHelper;
use App\Models\Clients\Alerts\Alert;
use App\Models\Clients\Reports\Report;
use App\Models\Commons\SensorType;
use App\Traits\ActiveTrait;
use App\Traits\AuthorTrait;
use App\Traits\CommonTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Sensor extends Model
{
	use SoftDeletes;
	use CommonTrait;
	use ActiveTrait;
	use AuthorTrait;
	public $timestamps = true;
	protected $fillable = [
		'author_id',
		'device_id',
		'sensor_type_id',
		'name',
		'active',
	];




	public function getLatestLog()
	{
		return $this->logs()->orderBy('created_at','DESC')->first();
	}

	public function getLogs($start,$end)
	{
		return $this->logs()->whereBetween('created_at', [$start, $end])->get()->map(function($l){
			return [
				'date'  => $l->created_at->format('Y-m-d H:i:s'),
				'value'  => $l->value,
			];
		});
	}










	public function getMapList() {
		return [
			'entity'          => 'sensors',
			'id'              => $this->getAttribute('id'),
			'name'            => $this->getShortName(),
			'sensor_type'     => $this->getShortSensorTypeName(),
			'author'          => $this->getShortAuthorName(),
			'n_alerts'        => $this->getAlertsCount(),
			'n_reports'       => $this->getReportsCount(),
			'created_at'      => $this->getCreatedAtFormatted(),
			'created_at_time' => $this->getCreatedAtTime(),
			'active'          => $this->getActiveFullResponse()
		];
	}

	public function getMaptoSelectList() {
		return [
			'id'          => $this->id,
			'description' => $this->getShortName()
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

	public function getMinValue()
	{
		return $this->sensor_type->getMinValue();
	}

	public function getMaxValue()
	{
		return $this->sensor_type->getMaxValue();
	}

	public function getRange()
	{
		return $this->sensor_type->getRange();
	}

	public function getShortSensorTypeScale()
	{
		return $this->sensor_type->getScaleText();
	}

	public function getSensorTypeName()
	{
		return $this->sensor_type->getName();
	}

	public function getShortSensorTypeName()
	{
		return $this->sensor_type->getShortName();
	}

	public function getDeviceName()
	{
		return $this->device->getName();
	}

	public function getName()
	{
		return $this->getAttribute('name');
	}

	public function getShortName()
	{
		return str_limit($this->getAttribute('name'), 20);
	}

	public function getShortNameScale()
	{
		return $this->getAttribute('name') . ' (' . $this->getShortSensorTypeScale() . ')';
	}


	public function getAlertsCount()
	{
		return $this->alerts->count();
	}

	public function getReportsCount()
	{
		return $this->reports->count();
	}

	// ******************** RELASHIONSHIP ******************************
	public function device()
	{
		return $this->belongsTo(Device::class, 'device_id');
	}

	public function sensor_type()
	{
		return $this->belongsTo(SensorType::class, 'sensor_type_id');
	}

	public function alerts()
	{
		return $this->hasMany(Alert::class, 'sensor_id');
	}

	public function dashboards()
	{
		return $this->hasMany(Dashboard::class, 'sensor_id');
	}

	public function reports()
	{
		return $this->hasMany(Report::class, 'sensor_id');
	}

    public function logs()
    {
        return $this->hasMany(SensorLog::class, 'sensor_id');
    }





	public function generateData($period)
	{
		$now = Carbon::now();
		$begin = clone $now;
		$scale = 'PT1M';
		switch($period){
			case 0://		'0' => 'Hoje',
				$begin->setTime(0,0,0);
				break;
			case 1://		'1' => 'Última Hora',
				$begin->subHour();
				break;
			case 2://		'2' => 'Últimas 6 Horas',
				$begin->subHours(6);
				break;
			case 3://		'3' => 'Últimas 12 Horas',
				$begin->subHours(12);
				break;
			case 4://		'4' => 'Últimas 24 Horas',
				$begin->subHours(24);
				break;
		}

		$start = $begin->toDateTimeString();
		$end = $now->toDateTimeString();
		$values = $this->getRange();
		$data = BaseHelper::generateDateRangeInsert(1, $start, $end, $scale, $values);
		DB::table('sensor_logs')->insert($data);
	}


}