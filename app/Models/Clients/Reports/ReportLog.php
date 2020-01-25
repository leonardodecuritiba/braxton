<?php

namespace App\Models\Clients\Reports;

use App\Notifications\NotifyNewReport;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;

class ReportLog extends Model
{
	use SoftDeletes;
	use CommonTrait;
	public $timestamps = true;
	protected $fillable = [
		'report_id',
		'data'
	];



	public function notify()
	{
		$emails = $this->report->getEmails();
		if($emails != NULL){
			return Notification::route('mail', $emails)
                ->notify(new NotifyNewReport($this));
		}

	}

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
	public function report()
	{
		return $this->belongsTo(Report::class, 'report_id');
	}


}