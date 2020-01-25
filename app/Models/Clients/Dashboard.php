<?php

namespace App\Models\Clients;

use App\Helpers\BaseHelper;
use App\Traits\ActiveTrait;
use App\Traits\AuthorTrait;
use App\Traits\ClientTrait;
use App\Traits\CommonTrait;
use App\Traits\SensorTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dashboard extends Model
{
	use SoftDeletes;
	use CommonTrait;
	use ActiveTrait;
	use AuthorTrait;
	use ClientTrait;
	use SensorTrait;
	public $timestamps = true;
	protected $fillable = [
		'author_id',
		'client_id',
		'sensor_id',
		'size',
		'period',
		'color',
		'format',
		'bullet',
		'active',
	];

	public function setDataChart()
	{
		return $this->sensor->generateData( $period = 4 );
	}

	public function getMapList() {
		return [
			'entity'          => 'dashboards',
			'id'              => $this->id,
			'name'            => $this->getShortName(),
			'sensor'          => $this->getShortSensorName(),
			'sensor_type'     => $this->getShortSensorTypeName(),
			'period'          => $this->getAttribute('period'),
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

	public function isGauge()
	{
		return ($this->getAttribute('format') == BaseHelper::$_DASHBOARD_FORMAT_GAUGE_);
	}


	public function isCilinder()
	{
		return ($this->getAttribute('format') == BaseHelper::$_DASHBOARD_FORMAT_CILINDER_);
	}

	public function getDataChart()
	{
		$now = Carbon::now();
		$begin = clone $now;
		$values = NULL;
		if($this->isGauge()){
			$l = $this->sensor->getLatestLog();
			if($l != NULL){
				$values = [
					'date'      => $l->created_at->format('Y-m-d H:i:s'),
					'value'     => $l->value,
					'timestamp' => $l->created_at->timestamp,
				];
			}
		} else {
			switch($this->attributes['period']){
				case BaseHelper::$_DASHBOARD_PERIODS_TODAY_://		'0' => 'Hoje',
					$begin->setTime(0,0,0);
					break;
				case BaseHelper::$_DASHBOARD_PERIODS_LAST_H_://		'1' => 'Última Hora',
					$begin->subHour();
					break;
				case BaseHelper::$_DASHBOARD_PERIODS_LAST_6H_://		'2' => 'Últimas 6 Horas',
					$begin->subHours(6);
					break;
				case BaseHelper::$_DASHBOARD_PERIODS_LAST_12H_://		'3' => 'Últimas 12 Horas',
					$begin->subHours(12);
					break;
				case BaseHelper::$_DASHBOARD_PERIODS_LAST_24H_://		'4' => 'Últimas 24 Horas',
					$begin->subHours(24);
					break;
			}

			$start = $begin->toDateTimeString();
			$end = $now->toDateTimeString();
			$values = $this->sensor->getLogs($start, $end);

		}

//		$scale = 'PT1M';
//		$range = $this->sensor->getRange();
//		$values = BaseHelper::generateDateRange($start, $end, $scale, $range);



		return json_encode($values);
	}

	public function getDataChartOptions()
	{
		$latest_log = $this->getLatestLog();
		if($latest_log != NULL){
			$options = [
				'dashboard_id'  => $this->id,
				'sensor_id'     => $this->sensor_id,
				'timestamp'     => $latest_log->created_at->timestamp,
				'range'         => $this->getRange(),
				'color'         => $this->getColorText(),
				'format'        => $this->getFormatText(),
				'fill'          => $this->getFill(),
				'bullet'        => $this->getBulletText(),
				'scale'         => $this->getShortSensorTypeScale(),
			];
			return json_encode($options);
		}
		return json_encode($latest_log);

	}

	public function getDataOptions()
	{
		$options = [
			'sensor_id' => $this->sensor_id,
			'range'     => $this->getRange(),
			'color'     => $this->getColorText(),
			'format'    => $this->getFormatText(),
			'fill'      => $this->getFill(),
			'bullet'    => $this->getBulletText(),
			'scale'     => $this->getShortSensorTypeScale(),
		];
		return json_encode($options);
	}


	public function getSizeStyle()
	{
		return BaseHelper::$_DASHBOARD_SIZES_[$this->attributes['size']]['value'];
	}

	public function getSizeDiv()
	{
		return BaseHelper::$_DASHBOARD_SIZES_[$this->attributes['size']]['size'];
	}

	public function getShortName()
	{
		return $this->getShortPeriodText();
	}

	public function getShortPeriodText()
	{
		return BaseHelper::$_DASHBOARD_PERIODS_[$this->attributes['period']];
	}

	public function getPeriodText()
	{
		return BaseHelper::$_DASHBOARD_PERIODS_[$this->attributes['period']];
	}

	public function getColorText()
	{
		return $this->attributes['color'];
	}

	public function getFormatText()
	{
		return BaseHelper::$_DASHBOARD_FORMATS_[$this->attributes['format']]['value'];
	}

	public function getFill()
	{
		return ($this->getFormatText() == 'line') ? 0 : 0.8;
	}

	public function getBulletText()
	{
		return BaseHelper::$_DASHBOARD_BULLETS_[$this->attributes['bullet']]['value'];
	}

	// ******************** RELASHIONSHIP ******************************

	public function getAmChartsOptions()
	{
		return json_encode([
			"dataProvider"          => "",
			"type"                  => "serial",
			"theme"                 => "light",
			"marginRight"           => 20,
			"marginLeft"            => 55,
			"autoMarginOffset"      => 20,
			"mouseWheelZoomEnabled" => true,
			"dataDateFormat"        => "YYYY-MM-DD JJ:NN",
			"valueAxes"             => [
				"id"                => "v1",
				"axisAlpha"         => 0,
				"position"          => "left",
				"ignoreAxisWidth"   =>true,
			],
			"balloon"               => [
				"borderThickness"   => 1,
				"shadowAlpha"       => 0
			],
			"categoryField"         => "date",
			"categoryAxis"          => [
				// "parseDates"=> true,
				"gridPosition"      => "start",
				"gridAlpha"         => 0,
				"tickPosition"      => "start",
				"tickLength"        => 20,
				"dashLength"        => 1,
				"minorGridEnabled"  => true,
				"minPeriod"         => "mm",
				"parseDates"        => true
			],
			"graphs"                => [
				[
					"id"            => "g1",
					"balloon"       =>[
						"drop"              => true,
						"adjustBorderColor" => false,
						"color"             =>" #ffffff"
					],
					"bullet"            => $this->getBulletText(),
					"bulletBorderAlpha" => 1,
					"bulletColor"       => "#FFFFFF",
					"bulletSize"        => 5,
					"hideBulletsCount"  => 50,
					"lineThickness"     => 2,
					"lineColor"         => $this->getColorText(),
					"title"             => "red line",
					"useLineColorForBulletBorder"=> true,
					"valueField"        => "value",
					"balloonText"       => "<span>[[value]] " . $this->getShortSensorTypeScale() . "</span>"
				]
			],
			"chartCursor"           => [
				"categoryBalloonDateFormat"=> "DD/MM/YYYY JJ=>NN",
				"pan"               => true,
				"valueLineEnabled"  => true,
				"valueLineBalloonEnabled"=> true,
				"cursorAlpha"       => 1,
				"cursorColor"       => $this->getColorText(),
				"limitToGraph"      => "g1",
				"valueLineAlpha"    => 0.2,
				"valueZoomable"     => true,
				"cursorAlpha"       => 0,
			],
		]);
	}
}