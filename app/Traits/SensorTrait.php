<?php

namespace App\Traits;

use App\Models\Clients\Sensor;

trait SensorTrait {

	public function getLatestLog()
	{
		return $this->sensor->getLatestLog();
	}

	public function getSensorId()
	{
		return $this->sensor->id;
	}

	public function getRange()
	{
		return $this->sensor->getRange();
	}

	public function getShortSensorTypeScale()
	{
		return $this->sensor->getShortSensorTypeScale();
	}

	public function getShortSensorTypeName()
	{
		return $this->sensor->getShortSensorTypeName();
	}

	public function getShortSensorName()
	{
		return $this->sensor->getShortName();
	}

	public function getSensorName()
	{
		return $this->sensor->getName();
	}

	public function getDeviceName()
	{
		return $this->sensor->getDeviceName();
	}

	// ******************** RELASHIONSHIP ******************************

	public function sensor()
	{
		return $this->belongsTo(Sensor::class, 'sensor_id');
	}

}