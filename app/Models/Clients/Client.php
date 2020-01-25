<?php

namespace App\Models\Clients;

use App\Models\Clients\Alerts\Alert;
use App\Models\Clients\Reports\Report;
use App\Models\Commons\Address;
use App\Models\Commons\Contact;
use App\Models\Users\User;
use App\Traits\ActiveTrait;
use App\Traits\ClientsTrait;
use App\Traits\CommonTrait;
use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
	use CommonTrait;
    use ClientsTrait;
    use UserTrait;
	use ActiveTrait;
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'address_id',
        'contact_id',
        'type',
        'sex',
        'fantasy_name',
        'company_name'
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

    public function getCompanyName()
    {
        return ($this->attributes['company_name'] != "") ? $this->getAttribute('company_name') : "-";
    }

    public function getShortName()
    {
        return ($this->attributes['type']) ? $this->getAttribute('company_name') : $this->user->getShortName();
    }


	// **************************************************************
	// **************************************************************
	// ******************** Dashboards ******************************
	public function getActiveDashboards()
	{
		return $this->active_dashboards;
	}

	public function getDashboards()
	{
		return $this->dashboards;
	}

	public function createDashboard( $data )
	{
		$data['client_id'] = $this->getAttribute('id');
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


	// ******************** SubClients *******************************
	public function getActiveSubclients()
	{
		return $this->active_sub_clients;
	}

	public function getSubclients()
	{
		return $this->sub_clients;
	}

	public function createSubClient( $data )
	{
		$data['client_id'] = $this->getAttribute('id');
		return SubClient::create($data);
	}

	public function findMySubclient( $id )
	{
		$data = $this->sub_clients->where( 'id', $id );
		return ( $data->count() > 0 ) ? $data->first() : abort( 403 );
	}

	public function isMySubclient( $id ) {
		$data = $this->sub_clients->where( 'id', $id );
		return ( $data->count() > 0 );
	}


	// ******************** Devices **********************************
	public function getActiveDevices()
	{
		return $this->active_devices;
	}

	public function getDevices()
	{
		return $this->devices;
	}

	public function createDevice( $data )
	{
		$data['client_id'] = $this->getAttribute('id');
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
	public function getActiveAlerts()
	{
		return $this->active_alerts;
	}

	public function getAlerts()
	{
		return $this->alerts;
	}

	public function createAlert( $data )
	{
		$data['client_id'] = $this->getAttribute('id');
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
	public function getActiveReports()
	{
		return $this->active_reports;
	}

	public function getReports()
	{
		return $this->reports;
	}

	public function createReport( $data )
	{
		$data['client_id'] = $this->getAttribute('id');
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
	public function getActiveSensors()
	{
		return $this->active_sensors();
	}

	public function getSensors()
	{
		return $this->sensors();
	}

	public function createSensor( $data )
	{
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
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function sub_clients()
    {
        return $this->hasMany(SubClient::class, 'client_id');
    }

    public function active_sub_clients()
    {
        return $this->hasMany(SubClient::class, 'client_id')->active();
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'client_id');
    }

    public function active_devices()
    {
        return $this->hasMany(Device::class, 'client_id')->active();
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class, 'client_id');
    }

	public function active_alerts()
	{
		return $this->hasMany(Alert::class, 'client_id')->active();
	}

    public function reports()
    {
        return $this->hasMany(Report::class, 'client_id');
    }

	public function active_reports()
	{
		return $this->hasMany(Report::class, 'client_id')->active();
	}

    public function sensors()
    {
        return Sensor::whereIn('device_id',$this->devices->pluck('id'))->get();
    }

	public function active_sensors()
	{
		return Sensor::whereIn('device_id',$this->devices->pluck('id'))->active()->get();
	}

	public function dashboards()
	{
		return $this->hasMany(Dashboard::class, 'client_id');
	}

	public function active_dashboards()
	{
		return $this->hasMany(Dashboard::class, 'client_id')->active();
	}
}