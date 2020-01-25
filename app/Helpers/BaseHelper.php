<?php

namespace App\Helpers;

class BaseHelper {

	// =======================================================
	// ============== DASHBOARDS =============================
	// =======================================================

	// ============== DASHBOARDS OPTIONS =====================

	static public $_DASHBOARD_COLORS_ = ["#FF6600", "#FCD202", "#B0DE09", '#1f77b4', '#aec7e8', '#2ca02c', '#98df8a', '#d62728', '#9467bd', '#c5b0d5', '#ff9896', '#8c564b', '#ff7f0e', '#ffbb78', '#c49c94', '#e377c2', '#f7b6d2', '#7f7f7f', '#c7c7c7', '#bcbd22', '#dbdb8d', '#17becf', '#9edae5'];//Email padrão para execução dos testes, ou seja sempre que $debug != 0
	static public $_DASHBOARD_BULLETS_ = [
		0 => ['text' =>'&#9675;',   'value' => 'round'],
		1 => ['text' =>'&#9633;',   'value' => 'square'],
		2 => ['text' =>'&#9651;',   'value' => 'triangleUp'],
		3 => ['text' =>'&#9661;',   'value' => 'triangleDown'],
		4 => ['text' =>'&#9679;',   'value' => 'bubble'],
	];

	static public function map_dashboard_bullets_text($val = 4)
	{
		$array = array_slice(self::$_DASHBOARD_BULLETS_,0, $val);
		return array_map(function($s){return $s['text'];},$array);
	}

	static public $_DASHBOARD_FORMAT_GAUGE_ = 2;
	static public $_DASHBOARD_FORMAT_CILINDER_ = 3;
	static public $_DASHBOARD_FORMATS_ = [
		0 => ['text' =>'Linha',   'value' => 'line'],
		1 => ['text' =>'Coluna',  'value' => 'column'],
		2 => ['text' =>'Gauge',   'value' => 'gauge'],
		3 => ['text' =>'Cilindro','value' => 'cilinder'],
	];

	static public function map_dashboard_formats_text($val = 4)
	{
		$array = array_slice(self::$_DASHBOARD_FORMATS_,0, $val);
		return array_map(function($s){return $s['text'];},$array);
	}


	static public $_DASHBOARD_SIZES_ = [
		0 => ['text' =>'Pequeno',   'value' => '200px',   'size' => '3'],
		1 => ['text' =>'Médio',     'value' => '300px',   'size' => '6'],
		2 => ['text' =>'Grande',    'value' => '400px',   'size' => '12'],
	];

	static public function map_dashboard_sizes_text($val = 3)
	{
		$array = array_slice(self::$_DASHBOARD_SIZES_,0, $val);
		return array_map(function($s){return $s['text'];},$array);
	}


	static public $_DASHBOARD_PERIODS_TODAY_ = 0;
	static public $_DASHBOARD_PERIODS_LAST_H_ = 1;
	static public $_DASHBOARD_PERIODS_LAST_6H_ = 2;
	static public $_DASHBOARD_PERIODS_LAST_12H_ = 3;
	static public $_DASHBOARD_PERIODS_LAST_24H_ = 4;

	static public $_DASHBOARD_PERIODS_ = [
		'0' => 'Hoje',
		'1' => 'Última Hora',
		'2' => 'Últimas 6 Horas',
		'3' => 'Últimas 12 Horas',
		'4' => 'Últimas 24 Horas',
		'5' => 'Hora Atual',
		'6' => 'Dia atual',
		'7' => 'Últimos 7 dias',
		'8' => 'Últimos 15 dias',
		'9' => 'Desde início do mês',
		'10' => 'Mês atual',
		'11' => 'Últimos 3 meses',
		'12' => 'Desde início do ano'
	];

	static public $_DAYS_OF_WEEK_ = [
		'Domingo',
		'Segunda',
		'Terça',
		'Quarta',
		'Quinta',
		'Sexta',
		'Sábado'
	];

	static public $_SHORT_DAYS_OF_WEEK_ = [
		'Dom',
		'Seg',
		'Ter',
		'Qua',
		'Qui',
		'Sex',
		'Sáb'
	];

	// =======================================================
	// ============== ALERTS =================================
	// =======================================================

	// ============== ALERTS TYPES ===========================

	static public $_ALERT_TYPE_SENSOR_FAIL_ = 0;
	static public $_ALERT_TYPE_ENERGY_FAIL_ = 1;
	static public $_ALERT_TYPE_INACTIVITY_ = 2;
	static public $_ALERT_TYPE_VALUE_ = 3;

	static public $_ALERT_TYPES_ = [
		'0' => 'Falha do Sensor',
		'1' => 'Falha de Energia',
		'2' => 'Sensor Inativo',
		'3' => 'Valor de Indicador'
	];

	// ============== ALERTS CONDITIONS ======================

	static public $_ALERT_CONDITION_IN_RANGE_       = 0;
	static public $_ALERT_CONDITION_OUT_RANGE_      = 1;
	static public $_ALERT_CONDITION_EQUAL_          = 2;
	static public $_ALERT_CONDITION_DIFFERENT_      = 3;
	static public $_ALERT_CONDITION_GREATER_        = 4;
	static public $_ALERT_CONDITION_GREATER_EQUAL_  = 5;
	static public $_ALERT_CONDITION_LOWER_          = 6;
	static public $_ALERT_CONDITION_LOWER_EQUAL_    = 7;

	static public $_ALERT_CONDITIONS_ = [
		'0' => 'Dentro da faixa entre',
		'1' => 'Fora da faixa entre',
		'2' => 'Igual a',
		'3' => 'Diferente de',
		'4' => 'Maior que',
		'5' => 'Maior ou igual a',
		'6' => 'Menor que',
		'7' => 'Menor ou igual a'
	];


	// =======================================================
	// ============== REPORTS ================================
	// =======================================================

	// ============== REPORT REPETITIONS =====================

	static public $_REPETITIONS_MENSAL_ = 0;
	static public $_REPETITIONS_SEMANAL_ = 1;
	static public $_REPETITIONS_DIARIO_ = 2;

	static public $_REPORT_REPETITIONS_ = [
		0 => ['text' =>'Mensalmente',   'value' => 'P1M'],
		1 => ['text' =>'Semanalmente',  'value' => 'P7D'],
		2 => ['text' =>'Diariamente',   'value' => 'P1D'],
	];

	static public function map_report_repetitions_text($val = 2)
	{
		$array = array_slice(self::$_REPORT_REPETITIONS_,0, $val);
		return array_map(function($s){return $s['text'];},$array);
	}


	// ============== REPORT INTERVALS =======================

	static public $_INTERVAL_MINUTO_ = 0;
	static public $_INTERVAL_HORA_ = 1;
	static public $_INTERVAL_INTERVALO_ = 2;
	static public $_INTERVAL_DIA_ = 3;

	static public $_REPORT_INTERVALS_ = [
		0 => ['text' =>'Por Minuto',     'value' => 'PT1M'],
		1 => ['text' =>'Por Hora',       'value' => 'PT1H'],
		2 => ['text' =>'Por Intervalo',  'value' => 'INTERVAL'],
		3 => ['text' =>'Por Dia',        'value' => 'P1D'],
	];

	static public function map_report_intervals_text($val = 3)
	{
		$array = array_slice(self::$_REPORT_INTERVALS_,0, $val);
		return array_map(function($s){return $s['text'];},$array);
	}

	// =======================================================
	// ============== FUNCTIONS ==============================
	// =======================================================

	static public function generateDateRange($start_date, $end_date, $scale = 'P1D', $range)
	{
		$dates = [];
		$begin = new \DateTime( $start_date );
		$end   = new \DateTime( $end_date );

		$interval  = new \DateInterval( $scale );
		$daterange = new \DatePeriod( $begin, $interval, $end );

		$value_begin = rand( $range[0], $range[1] );
		foreach ( $daterange as $date ) {
			$signal  = ( ( mt_rand( 1, 10 ) % 2 ) == 0 ) ? ( - 1 ) : 1;
			$value   = $signal * mt_rand( 0, round( $range[1] * 0.1 ) );
			$dates[] = [
				'date'  => $date->format( "Y-m-d H:i" ),
				'value' => $value_begin + $value
			];
		}

		return $dates;
	}

	static public function generateDateRangeInsert($sensor_id = 1, $start_date, $end_date, $scale = 'P1D', $range)
	{
		$dates = [];
		$begin = new \DateTime( $start_date );
		$end = new \DateTime( $end_date );
		$variation = 0.6;

		$interval = new \DateInterval($scale);
		$daterange = new \DatePeriod($begin, $interval ,$end);

		$value_begin = rand($range[0],$range[1]);
		foreach($daterange as $date){
			$signal = ((mt_rand(1,10) % 2) == 0) ? (-1) : 1;
			$value =  $signal * mt_rand(0, round($range[1] * $variation)) ;
			$dates[] = [
				'sensor_id'     => $sensor_id,
				'created_at'    => $date->format("Y-m-d H:i"),
//				'created_at'    => $date->format("Y-m-d H:i:s"),
				'value'         => $value_begin + $value
			];
		}
		return $dates;
	}
}
