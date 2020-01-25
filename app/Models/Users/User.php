<?php

namespace App\Models\Users;

use App\Models\Admins\Admin;
use App\Models\Clients\Client;
use App\Models\Clients\SubClient;
use App\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use ActiveTrait;
    use EntrustUserTrait {
        restore as private restoreA;
    } // add this trait to your user model

    use SoftDeletes {
        restore as private restoreB;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'name', 'password', 'active',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function getShortEmail()
    {
    	return $this->getAttribute('email');
    }
    
    public function getShortName()
    {
    	$name = str_limit($this->getAttribute('name'), 20);
    	if($this->hasRole('admin')){
		    $name .= ' (Admin)';
	    }
        return $name;
    }

    public function getName()
    {
    	$name = $this->getAttribute('name');
    	if($this->hasRole('admin')){
		    $name .= ' (Admin)';
	    }
        return $name;
    }

	public function updatePassword( $password ) {
		return $this->update( [
			'password' => bcrypt( $password )
		] );
	}

    public function itsAdmin()
    {
        return $this->getRole()->name == 'admin';
    }

    public function getShortRoleName()
    {
        return $this->getRole()->display_name;
    }

    public function getRole()
    {
        return $this->roles()->first();
    }


	public function itsMe( $id )
	{
		return ( $this->getAttribute( 'id' ) == $id );
	}


	public function getEntity()
	{
		if($this->hasRole('client')){
			return $this->client;
		} else if($this->hasRole('sub_client')) {
			return $this->sub_client;
		} else {
			return $this->admin;
		}
	}

	// **************************************************************
	// **************************************************************
	// ******************** Dashboards ******************************
	public function getActiveDashboards()
	{
		if($this->hasRole('client')){
			$data = $this->client->active_dashboards;
		} else if($this->hasRole('sub_client')) {
			$data =  $this->sub_client->active_dashboards;
		} else {
			$data = $this->admin->active_dashboards();
		}
		return $data;
	}

	public function getDashboards()
	{
		if($this->hasRole('client')){
			$data = $this->client->dashboards;
		} else if($this->hasRole('sub_client')) {
			$data =  $this->sub_client->dashboards;
		} else {
			$data = $this->admin->dashboards();
		}
		return $data;
	}

	public function createDashboard( $data )
	{
		return $this->getEntity()->createDashboard($data);
	}

	public function findMyDashboard( $id )
	{
		return $this->getEntity()->findMyDashboard( $id);
	}

	public function isMyDashboard( $id )
	{
		return $this->getEntity()->isMyDashboard( $id);
	}


	// ******************** Subclients *******************************

	public function getActiveSubclients()
	{
		return $this->getEntity()->getActiveSubclients();
	}

	public function getSubclients()
	{
		return $this->getEntity()->getSubclients();
	}

	public function createSubclient( $data )
	{
		return $this->getEntity()->createSubclient($data);
	}

	public function findMySubclient( $id )
	{
		return $this->getEntity()->findMySubclient( $id);
	}

	public function isMySubclient( $id )
	{
		return $this->getEntity()->isMySubclient( $id);
	}



	// ******************** Clients *******************************
	public function getActiveClients()
	{
		return $this->getEntity()->getActiveClients();
	}

	public function getClients()
	{
		return Client::getAlltoSelectList();
	}

	// ******************** Devices **********************************
	public function getActiveDevices()
	{
		return $this->getEntity()->getActiveDevices();
	}

	public function getDevices()
	{
		return $this->getEntity()->getDevices();
	}

	public function createDevice( $data )
	{
		return $this->getEntity()->createDevice($data);
	}

	public function findMyDevice( $id )
	{
		return $this->getEntity()->findMyDevice( $id);
	}

	public function isMyDevice( $id )
	{
		return $this->getEntity()->isMyDevice( $id);
	}


	// ******************** Alerts ***********************************
	public function getActiveAlerts()
	{
		return $this->getEntity()->getActiveAlerts();
	}

	public function getAlerts()
	{
		return $this->getEntity()->getAlerts();
	}

	public function createAlert( $data )
	{
		return $this->getEntity()->createAlert($data);
	}

	public function findMyAlert( $id )
	{
		return $this->getEntity()->findMyAlert( $id);
	}

	public function isMyAlert( $id )
	{
		return $this->getEntity()->isMyAlert( $id);
	}


	// ******************** Reports **********************************
	public function getActiveReports()
	{
		return $this->getEntity()->getActiveReports();
	}

	public function getReports()
	{
		return $this->getEntity()->getReports();
	}

	public function createReport( $data )
	{
		return $this->getEntity()->createReport($data);
	}

	public function findMyReport( $id )
	{
		return $this->getEntity()->findMyReport( $id);
	}

	public function isMyReport( $id )
	{
		return $this->getEntity()->isMyReport( $id);
	}


	// ******************** Sensors **********************************
	public function getActiveSensors()
	{
		return $this->getEntity()->getActiveSensors();
	}

	public function getSensors()
	{
		return $this->getEntity()->getSensors();
	}

	public function createSensor( $data )
	{
		return $this->getEntity()->createSensor($data);
	}

	public function findMySensor( $id )
	{
		return $this->getEntity()->findMySensor( $id);
	}

	public function isMySensor( $id )
	{
		return $this->getEntity()->isMySensor( $id);
	}


	// ***************************************************************
	// ***************************************************************


    // ******************** RELASHIONSHIP ******************************
	public function client()
	{
		return $this->hasOne( Client::class, 'user_id' );
	}

	public function sub_client()
	{
		return $this->hasOne( SubClient::class, 'user_id' );
	}

	public function admin()
	{
		return $this->hasOne( Admin::class, 'user_id' );
	}


}
