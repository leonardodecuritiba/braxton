<?php

namespace App\Models\Admins;

//use App\Traits\ActiveTrait;
//use App\Traits\ClientsTrait;
use App\Models\Clients\Alerts\Alert;
use App\Models\Clients\Client;
use App\Models\Clients\Dashboard;
use App\Models\Clients\Device;
use App\Models\Clients\Reports\Report;
use App\Models\Clients\Sensor;
use App\Models\Clients\SubClient;
use App\Traits\CommonTrait;
use App\Models\Users\User;
use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;
    use UserTrait;
//    use ClientsTrait;
    use CommonTrait;
//    use ActiveTrait;
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'about',
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

	public function getActiveFullResponse()
	{
		return $this->user->getActiveFullResponse();
	}






	// **************************************************************
	// **************************************************************
	// ******************** Dashboards ******************************
	public function getActiveDashboards()
	{
		return $this->active_dashboards();
	}

	public function getDashboards()
	{
		return $this->dashboards();
	}

	public function createDashboard( $data )
	{
		return Dashboard::create($data);
	}

	public function findMyDashboard( $id )
	{
		$data = $this->dashboards()->where( 'id', $id );
		return ( $data->count() > 0 ) ? $data->first() : abort( 403 );
	}

	public function isMyDashboard( $id ) {
		$data = $this->dashboards()->where( 'id', $id );
		return ( $data->count() > 0 );
	}


	// ******************** SubClients *******************************
	public function getActiveSubclients()
	{
		return $this->active_sub_clients();
	}

	public function getSubclients()
	{
		return $this->sub_clients();
	}

	public function createSubClient( $data )
	{
		return SubClient::create($data);
	}

	public function findMySubclient( $id )
	{
		$data = $this->sub_clients()->where( 'id', $id );
		return ( $data->count() > 0 ) ? $data->first() : abort( 403 );
	}

	public function isMySubclient( $id ) {
		$data = $this->sub_clients()->where( 'id', $id );
		return ( $data->count() > 0 );
	}


	// ******************** Clients *******************************
	public function getActiveClients()
	{
		return $this->active_clients();
	}

	public function getClients()
	{
		return $this->clients();
	}

	public function createClient( $data )
	{
		return Client::create($data);
	}

	public function findMyClient( $id )
	{
		$data = $this->clients()->where( 'id', $id );
		return ( $data->count() > 0 ) ? $data->first() : abort( 403 );
	}

	public function isMyClient( $id ) {
		$data = $this->clients()->where( 'id', $id );
		return ( $data->count() > 0 );
	}


	// ******************** Devices **********************************
	public function getActiveDevices()
	{
		return $this->active_devices();
	}

	public function getDevices()
	{
		return $this->devices();
	}

	public function createDevice( $data )
	{
		return Device::create($data);
	}

	public function findMyDevice( $id )
	{
		$data = $this->devices()->where( 'id', $id );
		return ( $data->count() > 0 ) ? $data->first() : abort( 403 );
	}

	public function isMyDevice( $id )
	{
		$data = $this->devices()->where( 'id', $id );
		return ( $data->count() > 0 );
	}

	// ******************** Alerts ***********************************
	// ******************** Reports **********************************
	public function getActiveAlerts()
	{
		return $this->active_alerts();
	}

	public function getAlerts()
	{
		return $this->alerts();
	}

	public function createAlert( $data )
	{
		$data['client_id'] = Device::findOrFail($data['device_id'])->client_id;
		return Alert::create($data);
	}

	public function findMyAlert( $id )
	{
		$data = $this->alerts()->where( 'id', $id );
		return ( $data->count() > 0 ) ? $data->first() : abort( 403 );
	}

	public function isMyAlert( $id )
	{
		$data = $this->alerts()->where( 'id', $id );
		return ( $data->count() > 0 );
	}


	// ******************** Reports **********************************
	public function getActiveReports()
	{
		return $this->active_reports();
	}

	public function getReports()
	{
		return $this->reports();
	}

	public function createReport( $data )
	{
		$data['client_id'] = Device::findOrFail($data['device_id'])->client_id;
		return Report::create($data);
	}

	public function findMyReport( $id )
	{
		$data = $this->reports()->where( 'id', $id );
		return ( $data->count() > 0 ) ? $data->first() : abort( 403 );
	}

	public function isMyReport( $id )
	{
		$data = $this->reports()->where( 'id', $id );
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
		$data = $this->sensors()->where( 'id', $id );
		return ( $data->count() > 0 ) ? $data->first() : abort( 403 );
	}

	public function isMySensor( $id )
	{
		$data = $this->sensors()->where( 'id', $id );
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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

	public function clients()
	{
		return Client::all();
	}

	public function active_clients()
	{
		return Client::active()->get();
	}

	public function devices()
	{
		return Device::all();
	}

	public function active_devices()
	{
		return Device::active()->get();
	}

	public function sub_clients()
	{
		return SubClient::all();
	}

	public function active_sub_clients()
	{
		return SubClient::active()->get();
	}

	public function alerts()
	{
		return Alert::all();
	}

	public function active_alerts()
	{
		return Alert::active()->get();
	}

	public function reports()
	{
		return Report::all();
	}

	public function active_reports()
	{
		return Report::active()->get();
	}

	public function sensors()
	{
		return Sensor::all();
	}

	public function active_sensors()
	{
		return Sensor::active()->get();
	}

	public function dashboards()
	{
		return Dashboard::all();
	}

	public function active_dashboards()
	{
		return Dashboard::active()->get();
	}
}