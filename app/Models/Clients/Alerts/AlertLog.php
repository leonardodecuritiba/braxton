<?php

namespace App\Models\Clients\Alerts;

use App\Helpers\DataHelper;
use App\Notifications\NotifyNewAlertInactivity;
use App\Notifications\NotifyNewAlertValues;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;

class AlertLog extends Model
{
	use SoftDeletes;
	use CommonTrait;
	public $timestamps = true;
	protected $fillable = [
		'alert_id',
		'data'
	];


	// =======================================================
	// ============== INACTIVITY =============================
	// =======================================================

	public function notifyInactivity()
	{
		$emails = $this->alert->getEmails();
		if($emails != NULL){
			return Notification::route('mail', $emails)
			                   ->notify(new NotifyNewAlertInactivity($this));
		}

	}

	public function notifyValue()
	{
		$emails = $this->alert->getEmails();
		if($emails != NULL){
			return Notification::route('mail', $emails)
			                   ->notify(new NotifyNewAlertValues($this));
		}

	}

	public function getLastActivity()
	{
		return DataHelper::getFullPrettyDateTime($this->data->latest_log);
	}

	public function getDataLog()
	{
		return json_encode($this->data);
	}

	public function getDataLogText()
	{
		return json_encode($this->data);
	}

	public function getMessage()
	{
		return $this->data->message;
	}

	// =======================================================
	// ============== FUNCTIONS ==============================
	// =======================================================


	public function setDataAttribute($value)
	{
		return $this->attributes['data'] = json_encode($value);
	}

	public function getDataAttribute()
	{
		return json_decode($this->attributes['data']);
	}

	public function getDataResponse()
	{
		return $this->data->response;
	}

	// ******************** RELASHIONSHIP ******************************
	public function alert()
	{
		return $this->belongsTo(Alert::class, 'alert_id');
	}


}