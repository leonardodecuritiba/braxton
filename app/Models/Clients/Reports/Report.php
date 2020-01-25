<?php

namespace App\Models\Clients\Reports;

use App\Helpers\BaseHelper;
use App\Helpers\ReportHelper;
use App\Notifications\NotifyNewReport;
use App\Traits\ActiveTrait;
use App\Traits\AuthorTrait;
use App\Traits\ClientTrait;
use App\Traits\CommonTrait;
use App\Traits\SendTrait;
use App\Traits\SensorTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
	use SoftDeletes;
	use CommonTrait;
	use ActiveTrait;
	use AuthorTrait;
	use SensorTrait;
	use ClientTrait;
	use SendTrait;
	public $timestamps = true;
	protected $fillable = [
		'author_id',
		'client_id',
		'sensor_id',
		'name',
		'repetition',
		'repetition_option',
		'execution_at',
		'interval',
		'time',
		'send_email',
		'main_email',
		'copy_email',
		'active',
	];

	protected $dates = [
		'execution_at'
	];

	// =======================================================
	// ============== REPORT FUNCTION ========================
	// =======================================================

	static public function allToRun()
	{
		return self::active()->where('execution_at','<',Carbon::now())->get();
	}

	public function run()
	{
		$ReportHelper = new ReportHelper($this);

		$ReportHelper->run();
//		switch($this->getAttribute('repetition')){
//			case BaseHelper::$_REPETITIONS_MENSAL_:
//				$ReportHelper->month();
//				break;
//			case BaseHelper::$_REPETITIONS_SEMANAL_:
//				$ReportHelper->week();
//				break;
//			case BaseHelper::$_REPETITIONS_DIARIO_:
//				switch($this->getAttribute('interval')){
//					case BaseHelper::$_INTERVAL_MINUTO_:
//						$ReportHelper->minute();
//						break;
//					case BaseHelper::$_INTERVAL_HORA_:
//						$ReportHelper->hour();
//						break;
//					case BaseHelper::$_INTERVAL_DIA_:
//					case BaseHelper::$_INTERVAL_INTERVALO_:
//						$ReportHelper->interval();
//						break;
//				}
//		}

		return $ReportHelper->formatedData();

	}

	public function storeLog()
	{
		$data = $this->run();

		$ReportLog = NULL;

		if($data != NULL){
			$ReportLog = ReportLog::create([
				'report_id' => $this->id,
				'data'  => $data,
			]);
			$ReportLog->notify(); //NOTIFY
		}

		$this->updateNextExecutionDB();
		return $ReportLog;

	}

	// =======================================================
	// ============== REPORT FUNCTION ========================
	// =======================================================


	public function updateNextExecutionDB()
	{
		$next = clone $this->execution_at;

		switch($this->getAttribute('repetition')){
			case BaseHelper::$_REPETITIONS_MENSAL_:
				$next->addMonth();
				break;
			case BaseHelper::$_REPETITIONS_SEMANAL_:
				$next->addWeek();
				break;
			case BaseHelper::$_REPETITIONS_DIARIO_:
				$next->addDay();
				break;
		}
		DB::table('reports')->where('id',$this->id)->update(['execution_at' => $next->toDateTimeString()]);
		return $this;
	}

	static public function getNextExecution(self $report)
	{
		$now = Carbon::now();
		$execution_at = NULL;
		switch($report['repetition']){
			case BaseHelper::$_REPETITIONS_MENSAL_:
				//MENSALMENTE
				$day = $report['repetition_option'];
				$h = $report->getHourEnd();
				$m = $report->getMinuteEnd();
				$next = Carbon::create(NULL, NULL, $day, $h, $m);
				if($now->diffInMinutes($next,false) < 0){
					$next->addMonth();
				}
				$execution_at = $next;
				break;
			case BaseHelper::$_REPETITIONS_SEMANAL_:
				//SEMANALMENTE
				$day_of_week = $report['repetition_option'];
				$h = $report->getHourEnd();
				$m = $report->getMinuteEnd();

				if($now->dayOfWeek > $day_of_week){
					//se hoje é maior que o dia de agendamento, entao já passou
					$next = clone $now;
					$next->previous($day_of_week);
					$next->setTime($h,$m);
					$next->addWeek();
				} else if($now->dayOfWeek == $day_of_week) {
					//se é igual, vamos ver se já foi, ou vai ser hoje mais tarde
					$next = Carbon::create(NULL, NULL, NULL, $h, $m);
					if($now->diffInMinutes($next,false) < 0){
						$next->addWeek();
					}
				} else {
					//senão ou foi hoje mais cedo ou ainda não veio
					$next = clone $now;
					$next->next($day_of_week);
					$next->setTime($h,$m);
				}
				$execution_at = $next;
				break;
			case BaseHelper::$_REPETITIONS_DIARIO_:
				//DIARIAMENTE
				$h = $report->getHourEnd();
				$m = $report->getMinuteEnd();
				$next = Carbon::create(NULL, NULL, NULL, $h, $m);
				if($now->diffInMinutes($next,false) < 0){
					$next->addDay();
				}
				$execution_at = $next;
				break;
		}
		return $execution_at;
	}

	public function getMapList() {
		return [
			'entity'            => 'reports',
			'id'                => $this->id,
			'author'            => $this->getAuthorName(),
			'name'              => $this->getName(),
			'short_name'        => $this->getShortName(),
			'sensor'            => $this->getShortSensorName(),
			'device'            => $this->getDeviceName(),
			'sensor_type'       => $this->getShortSensorTypeName(),
			'scale_type'        => $this->getShortSensorTypeScale(),
			'period_start'      => $this->getPeriodText('start'),
			'period_end'        => $this->getPeriodText('end'),
			'repetition'        => $this->getRepetitionText(),
			'interval_time'     => $this->getIntervalTimeText(),
			'execution_at'      => $this->getExecutionAtFormatted(),
			'execution_at_time' => $this->getExecutionAtTime(),
			'created_at'        => $this->getCreatedAtFormatted(),
			'created_at_time'   => $this->getCreatedAtTime(),
			'active'            => $this->getActiveFullResponse()
		];
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

	public function getName()
	{
		return ($this->attributes['name']);
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

	public function setTimeAttribute($value)
	{
		$this->attributes['time'] = json_encode($value);
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

	public function getHourBegin()
	{
		$time = $this->getTime();
		return substr ( $time[0], 0, 2);
	}

	public function getMinuteBegin()
	{
		$time = $this->getTime();
		return substr ( $time[0], 3, 2);
	}

	public function getTimeEnd()
	{
		$time = $this->getTime();
		return $time[1];
	}

	public function getHourEnd()
	{
		$time = $this->getTime();
		return substr ( $time[1], 0, 2);
	}

	public function getMinuteEnd()
	{
		$time = $this->getTime();
		return substr ( $time[1], 3, 2);
	}

	public function dayIsChecked($day)
	{
		if($this->getAttribute('repetition') == 1){
			return ($this->getAttribute('repetition_option') == $day);
		}
		return true;
	}

	public function getMonthDayOption()
	{
		if($this->getAttribute('repetition') == 0){
			return $this->getAttribute('repetition_option');
		}
		return true;
	}

	public function getPeriodText($period = NULL)
	{

		$start = clone $this->execution_at;
		$end = clone $this->execution_at;

		$start->setTime($this->getHourBegin(), $this->getMinuteBegin());
		$interval = new \DateInterval($this->getRepetitionValue());
		$start->sub($interval);

		if($period == 'start'){
			$text = $start->format('d/m/Y H:i:s');
		} else if($period == 'end'){
			$text = $end->format('d/m/Y H:i:s');
		} else {
			$text = $start->format('d/m/Y H:i:s') . ' - ' . $end->format('d/m/Y H:i:s') ;
		}

		return $text;

	}


	public function getIntervalTimeText()
	{
		return $this->getIntervalText() . ' (' . $this->getTimeText() . ')';
	}

	public function getIntervalText()
	{
		return BaseHelper::$_REPORT_INTERVALS_[$this->getAttribute('interval')]['text'];
	}

	public function getIntervalValue()
	{
		return BaseHelper::$_REPORT_INTERVALS_[$this->getAttribute('interval')]['value'];
	}

	public function getRepetitionText()
	{
		return BaseHelper::$_REPORT_REPETITIONS_[$this->getAttribute('repetition')]['text'];
	}

	public function getRepetitionValue()
	{
		return BaseHelper::$_REPORT_REPETITIONS_[$this->getAttribute('repetition')]['value'];
	}



	// ******************** RELASHIONSHIP ******************************

	public function logs()
	{
		return $this->hasMany(ReportLog::class, 'report_id');
	}
}