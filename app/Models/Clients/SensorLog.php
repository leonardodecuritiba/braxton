<?php

namespace App\Models\Clients;

use App\Traits\CommonTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SensorLog extends Model
{
	use CommonTrait;
	public $timestamps = true;
	protected $fillable = [
		'sensor_id',
		'value'
	];

	static public function getMoreData(array $data)
	{
		$last = Carbon::createFromTimestamp($data['timestamp'] )->toDateTimeString();
		$l = self::where('created_at','>', $last )->first();
		if(count($l) > 0 ){
			return [
				'date'      => $l->created_at->format('Y-m-d H:i:s'),
				'value'     => $l->value,
				'timestamp' => $l->created_at->timestamp,
			];
		}
		return NULL;
	}

	// ******************** RELASHIONSHIP ******************************
	public function sensor()
	{
		return $this->belongsTo(Sensor::class, 'sensor_id');
	}


}