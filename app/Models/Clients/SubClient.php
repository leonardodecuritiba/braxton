<?php

namespace App\Models\Clients;

use App\Models\Clients\Alerts\Alert;
use App\Models\Clients\Reports\Report;
use App\Traits\ActiveTrait;
use App\Traits\ClientTrait;
use App\Traits\CommonTrait;
use App\Models\Users\User;
use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubClient extends Model
{
    use SoftDeletes;
    use CommonTrait;
	use ClientTrait;
    use UserTrait;
    use ActiveTrait;
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'client_id',
    ];

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
        return $this->user->getShortName();
    }


	// **************************************************************
	// **************************************************************
	// ******************** Dashboards ******************************
	public function createDashboard( $data )
	{
		$data['client_id'] = $this->getAttribute('client_id');
		return Dashboard::create($data);
	}

	public function findMyDashboard( $id )
	{
		$data = $this->dashboards->where( 'id', $id );
		return ( $data->count() > 0 ) ? $data->first() : abort( 403 );
	}

	public function isMyDashboard( $id ) {
		$data = $this->dashboards->where( 'id', $id );
		return ( $data->count() > 0 );
	}


	// ******************** Devices **********************************
	public function getDevices()
	{
		return $this->devices;
	}

	public function createDevice( $data )
	{
		$data['client_id'] = $this->getAttribute('client_id');
		return Device::create($data);
	}

	public function findMyDevice( $id )
	{
		$data = $this->devices->where( 'id', $id );
		return ( $data->count() > 0 ) ? $data->first() : abort( 403 );
	}

	public function isMyDevice( $id )
	{
		$data = $this->devices->where( 'id', $id );
		return ( $data->count() > 0 );
	}

	// ******************** Alerts ***********************************
	public function getAlerts()
	{
		return $this->alerts;
	}

	public function createAlert( $data )
	{
		$data['client_id'] = $this->getAttribute('client_id');
		return Alert::create($data);
	}

	public function findMyAlert( $id )
	{
		$data = $this->alerts->where( 'id', $id );
		return ( $data->count() > 0 ) ? $data->first() : abort( 403 );
	}

	public function isMyAlert( $id ) {
		$data = $this->alerts->where( 'id', $id );
		return ( $data->count() > 0 );
	}


	// ******************** Reports **********************************
	public function getReports()
	{
		return $this->reports;
	}

	public function createReport( $data )
	{
		$data['client_id'] = $this->getAttribute('client_id');
		return Report::create($data);
	}

	public function findMyReport( $id )
	{
		$data = $this->reports->where( 'id', $id );
		return ( $data->count() > 0 ) ? $data->first() : abort( 403 );
	}

	public function isMyReport( $id ) {
		$data = $this->reports->where( 'id', $id );
		return ( $data->count() > 0 );
	}


	// ******************** Sensors **********************************
	public function getSensors()
	{
		return Sensor::whereIn('device_id',$this->devices->pluck('id'))->get();
	}

	public function createSensor( $data )
	{
		$data['client_id'] = $this->getAttribute('client_id');
		return Sensor::create($data);
	}

	public function findMySensor( $id )
	{
		$data = $this->getSensors()->where( 'id', $id );
		return ( $data->count() > 0 ) ? $data->first() : abort( 403 );
	}

	public function isMySensor( $id )
	{
		$data = $this->getSensors()->where( 'id', $id );
		return ( $data->count() > 0 );
	}


	// **************************************************************
	// **************************************************************






	public function getActiveFullResponse()
	{
		return $this->user->getActiveFullResponse();
	}
	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeActive($query)
	{
		return $query->whereHas('user', function ($q) {
			$q->active();
		});
	}
	/**
	 * Scope a query to only include active users.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeInactive($query)
	{
		return $query->whereHas('user', function ($q) {
			$q->inactive();
		});
	}

    // ******************** RELASHIONSHIP ******************************
	public function devices()
	{
		return $this->hasMany(Device::class, 'client_id','client_id');
	}

	public function alerts()
	{
		return $this->hasMany(Alert::class, 'client_id','client_id');
	}

	public function reports()
	{
		return $this->hasMany(Report::class, 'client_id','client_id');
	}

	public function dashboards()
	{
		return $this->hasMany(Dashboard::class, 'client_id','client_id');
	}

	public function active_dashboards()
	{
		return $this->hasMany(Dashboard::class, 'client_id','client_id')->active();
	}

}