<?php

namespace App\Helpers;

use App\Models\Clients\Reports\Report;
use Carbon\Carbon;


class ReportHelper {

	static public $_DEBUG_ = 0;
	public $start;
	public $end;
	public $report;
	public $sensor;
	public $data;

	public function __construct(Report $report) {
		$this->report = $report;
		$this->end = clone $this->report->execution_at;
		$this->start = clone $this->report->execution_at;
		$this->start->setTime($this->report->getHourBegin(), $this->report->getMinuteBegin());
		$this->sensor = $this->report->sensor;
	}
	// =======================================================
	// ============== REPORT RUN =============================
	// =======================================================

	public function run()
	{
		switch($this->report->repetition){
			case BaseHelper::$_REPETITIONS_MENSAL_:
				$this->month();
				break;
			case BaseHelper::$_REPETITIONS_SEMANAL_:
				$this->week();
				break;
			case BaseHelper::$_REPETITIONS_DIARIO_:
				switch($this->report->interval){
					case BaseHelper::$_INTERVAL_MINUTO_:
						$this->minute();
						break;
					case BaseHelper::$_INTERVAL_HORA_:
						$this->hour();
						break;
					case BaseHelper::$_INTERVAL_DIA_:
					case BaseHelper::$_INTERVAL_INTERVALO_:
					$this->interval();
						break;
				}
		}
	}

	// =======================================================
	// ============== REPORT SECOND ==========================
	// =======================================================

	public function second()
	{
		//BY DAY - MINUTE
		//SETTING BEGIN AND END TIME
		$this->data = $this->sensor->getLogs($this->start, $this->end);
	}


	// =======================================================
	// ============== REPORT MINUTE ==========================
	// =======================================================

	public function minute()
	{
		//BY DAY - MINUTE
		//SETTING BEGIN AND END TIME
		$this->data = $this->sensor->getLogs($this->start, $this->end);
		if(self::$_DEBUG_){
			dd($this->data);
		}
	}


	// =======================================================
	// ============== REPORT HOUR ============================
	// =======================================================

	public function hour()
	{
		//BY DAY - HOUR
		//SETTING BEGIN AND END TIME
		$begin = clone $this->start;
		$end = clone $this->end;

		$interval = 'PT1H';
		$interval = new \DateInterval($interval);

		$daterange = new \DatePeriod($begin, $interval, $this->end);

		$data = collect();
		foreach ($daterange as $start){
			$end->hour($start->hour);
			$da = [$start->toDateTimeString(), $end->toDateTimeString()];
			$start->add($interval);
			$sdata = $this->sensor->getLogs($da[0], $da[1]);

			if(self::$_DEBUG_){
				print_r('i: ' . $da[0] . ' | e: ' . $da[1] . ' count: ' . $sdata->count() . '<br><br>');
			} else {
				$data->push([
					'date'   => $da[1],
					'value'  => round($sdata->avg('value'), 2),
				]);
			}
		}
		if(self::$_DEBUG_){
			exit;
		}
		$this->data = $data;

	}


	// =======================================================
	// ============== REPORT WEEK ============================
	// =======================================================

	public function week()
	{
		//BY DAY - MINUTE
		//SETTING BEGIN AND END TIME
		$this->start->subWeek();
		$end = clone $this->start;

		$interval = 'P1D';
		$interval = new \DateInterval($interval);
		$daterange = new \DatePeriod($this->start, $interval, $this->end);

		$data = collect();
		foreach ($daterange as $start)
		{
			$start->addMinute();
			$end->setTime($this->end->hour, $this->end->minute);
			$da = [$start->toDateTimeString(), $end->toDateTimeString()];
			$sdata = $this->sensor->getLogs($da[0], $da[1]);

			if(self::$_DEBUG_){
				print_r('i: ' . $da[0] . ' | e: ' . $da[1] . ' count: ' . $sdata->count() . '<br><br>');
			} else {
				$data->push([
					'date'   => $da[1],
					'value'  => round($sdata->avg('value'), 2),
				]);
			}

			//UPDATE END
			$end->add($interval);
		}
		if(self::$_DEBUG_) {
			exit;
		}
		$this->data = $data;
	}


	// =======================================================
	// ============== REPORT MONTH ===========================
	// =======================================================

	public function month()
	{
		//BY DAY - MINUTE
		//SETTING BEGIN AND END TIME
		$this->start->subMonth();
		$end = clone $this->start;

		$interval = 'P1D';
		$interval = new \DateInterval($interval);
		$daterange = new \DatePeriod($this->start, $interval, $this->end);

		$data = collect();
		foreach ($daterange as $start)
		{
			$start->addMinute();
			$end->setTime($this->end->hour, $this->end->minute);
			$da = [$start->toDateTimeString(), $end->toDateTimeString()];
			$sdata = $this->sensor->getLogs($da[0], $da[1]);

			if(self::$_DEBUG_){
				print_r('i: ' . $da[0] . ' | e: ' . $da[1] . ' count: ' . $sdata->count() . '<br><br>');
			} else {
				$data->push([
					'date'   => $da[1],
					'value'  => round($sdata->avg('value'), 2),
				]);
			}
			$end->add($interval);
		}
		if(self::$_DEBUG_) {
			exit;
		}

		//UPDATE END
		$this->data = $data;
	}


	// =======================================================
	// ============== FUNCTIONS ==============================
	// =======================================================

	public function interval()
	{
		//BY DAY - INTERVAL
		//SETTING BEGIN AND END TIME
		$sdata = $this->sensor->getLogs($this->start, $this->end);
		$this->data = [
			'date'   => $this->end->toDateTimeString(),
			'value'  => round($sdata->avg('value'), 2),
		];
	}


	public function formatedData()
	{
		if(count($this->data)>0){

			$min = NULL;
			$max = NULL;
			$min_date = NULL;
			$max_date = NULL;
			$avg = NULL;


			if(!is_array($this->data)){
				$min = $this->data->min('value');
				$max = $this->data->max('value');

				$min_date = $this->data->where('value',$min)->first();
				$max_date = $this->data->where('value',$max)->first();
//			$min_date = Carbon::createFromFormat('Y-m-d H:i:s', $min_date['date'])->format('d/m/Y H:i:s');
//			$max_date = Carbon::createFromFormat('Y-m-d H:i:s', $max_date['date'])->format('d/m/Y H:i:s');
				$min_date = Carbon::createFromFormat('Y-m-d H:i:s', $min_date['date'])->format('d/m/Y H:i');
				$max_date = Carbon::createFromFormat('Y-m-d H:i:s', $max_date['date'])->format('d/m/Y H:i');
				$avg = round($this->data->avg('value'), 2);
				$data = $this->data;
			} else {
				$min = $this->data['value'];
				$max = $this->data['value'];
				$min_date = $this->data['date'];
				$max_date = $this->data['date'];
				$avg = $this->data['value'];
				$data = array($this->data);
			}


			return [
				'min'       => $min,
				'max'       => $max,
				'min_date'  => $min_date,
				'max_date'  => $max_date,
				'avg'       => $avg,
				'options'   => $this->getChartOptions(),
				'response'  => json_encode($data),
			];

		} else {
			return NULL;
		}
	}


	public function getChartOptions()
	{
		return json_encode([
//			'period' => $this->getPeriodText(),
			'color'     => '#FF6600',
			'format'    => "line",
			'fill'      => 0,
			'bullet'    => "round",
			'scale'     => "dB",
		]);
	}


}
