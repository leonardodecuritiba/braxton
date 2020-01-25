<?php

namespace App\Models\Clients\Alerts;

use App\Helpers\AlertHelper;
use App\Helpers\BaseHelper;
use App\Models\Clients\Client;
use App\Traits\ActiveTrait;
use App\Traits\AuthorTrait;
use App\Traits\ClientTrait;
use App\Traits\CommonTrait;
use App\Traits\SendTrait;
use App\Traits\SensorTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alert extends Model
{
	use SoftDeletes;
	use CommonTrait;
	use ActiveTrait;
	use AuthorTrait;
	use SensorTrait;
	use ClientTrait;
	use SendTrait;
	public $timestamps = true;
	public $now;
	protected $fillable = [
		'author_id',
		'client_id',
		'sensor_id',
		'name',
		'condition_type',
		'condition_values',
		'alert_type',
		'time',
		'days',
		'send_email',
		'main_email',
		'copy_email',
		'active',
	];

	// =======================================================
	// ============== ALERT FUNCTION =========================
	// =======================================================


	static public function allToRun()
	{
		return self::active()->get();
	}


	public function run()
	{
		$AlertHelper = new AlertHelper($this);
		return $AlertHelper->run();
	}

	// =======================================================
	// ============== ALERT FUNCTION =========================
	// =======================================================


	public function getMapList() {
		return [
			'entity'          => 'alerts',
			'id'              => $this->id,
			'name'            => $this->getShortName(),
			'type'            => $this->getAlertTypeText(),
			'sensor'          => $this->getShortSensorName(),
			'sensor_type'     => $this->getShortSensorTypeName(),
			'condition'       => $this->getAlertConditionText(),
			'time'            => $this->getTimeText(),
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

	public function getShortName()
	{
		return str_limit($this->getAttribute('name'), 20);
	}


	public function getEmails()
	{
		$emails = NULL;
		if($this->attributes['send_email']){
			if($this->attributes['main_email'] != NULL){
				$emails = array();
				$emails[] = $this->attributes['main_email'];
				$mail_copy = $this->getCopyEmailArray();
				if($mail_copy != NULL){
					if(is_array($mail_copy)){
						$emails = array_merge($emails, $mail_copy);
					} else {
						array_push($emails, $mail_copy);
					}
				}
			}
		}
		return $emails;
	}

	public function getCopyEmailArray()
	{
		return json_decode($this->attributes['copy_email']);
	}

	public function getAlertTypeText()
	{
		return BaseHelper::$_ALERT_TYPES_[$this->attributes['alert_type']];
	}

	public function getAlertConditionText()
	{
		$text = '-';
		if($this->attributes['alert_type'] == 2) {
			$values = $this->getConditionValues();
			$text = 'Tempo de Inatividade ' . $values . 'm';
		} else if($this->attributes['alert_type'] == 3){
			if($this->attributes['condition_type'] >= 0)
			{
				$text = BaseHelper::$_ALERT_CONDITIONS_[$this->attributes['condition_type']];
				$values = $this->getConditionValues();
				if($this->attributes['condition_type'] > 1)
				{
					$text .= ' ' . $values . ' ' . $this->getShortSensorTypeScale();
				} else {
					$text .= ' ' . $values[0] . ' e ' . $values[1] . ' ' . $this->getShortSensorTypeScale();
				}
			}
		}
		return $text;
	}

	public function setTimeAttribute($value)
	{
		$this->attributes['time'] = json_encode($value);
	}

	public function setDaysAttribute($value)
	{
		$this->attributes['days'] = json_encode(array_values($value));
	}

	public function setConditionValuesAttribute($value)
	{
		$this->attributes['condition_values'] = (count($value) > 1) ? json_encode($value) : $value;
	}

	public function getConditionValues()
	{
		$value = $this->attributes['condition_values'];
		if($value != NULL){
			$temp = explode(',',$this->attributes['condition_values']);
			if(($temp != NULL) && (count($temp)>1)){
				$value = $temp;
			} else {
				$value = $temp[0];
			}
		}
		return $value;
	}

	public function getDays()
	{
		 return json_decode($this->attributes['days']);
	}

	public function getInactiveTime()
	{
		if($this->attributes['alert_type'] == 2) {
			$value = $this->attributes['condition_values'];
		} else {
			$value = 30;
		}
		return $value;
	}

	public function getTime()
	{
		 return json_decode($this->attributes['time']);
	}

	public function getTimeText()
	{
		$time = $this->getTime();
		return implode(' às ',$time);
	}

	public function getTimeBegin()
	{
		$time = $this->getTime();
		return $time[0];
	}

	public function getTimeEnd()
	{
		$time = $this->getTime();
		return $time[1];
	}

	public function dayIsChecked($day)
	{
		return true;
	}


	// ******************** RELASHIONSHIP ******************************

	public function logs()
	{
		return $this->hasMany(AlertLog::class, 'alert_id');
	}
}