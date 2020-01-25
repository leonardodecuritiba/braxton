<?php

namespace App\Http\Controllers\Commons;

use App\Http\Controllers\Controller;
use App\Models\Clients\Job;
use App\Models\Clients\Sensor;
use App\Models\Clients\SensorLog;
use App\Models\Clients\Unit;
use App\Models\Commons\CepCities;
use App\Models\Commons\SubGroup;
use App\Models\Users\Permission;
use App\Models\Users\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Input;

class AjaxController extends Controller
{
    /**
     * gET the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSensorLastData()
    {
	    $data = SensorLog::getMoreData(Input::all());
	    return new JsonResponse( [
		    'status'  => 1,
		    'message' => $data
	    ], 200 );
    }
    /**
     * gET the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStateCityToSelect()
    {
        $idstate = Input::get('id');
        return ($idstate == NULL) ? $idstate : CepCities::where('idstate', $idstate)->get();
    }

	/**
	 * Active the specified resource from storage.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setActive() {

		$model  = Input::get( 'model' );
		$id     = Input::get( 'id' );
		$Entity = $model::findOrFail( $id );

		return new JsonResponse( [
			'status'  => 1,
			'message' => $Entity->updateActive()
		], 200 );
	}

	/**
	 * Active the specified resource from storage.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setActivePermissions()
	{
		$role_id  = Input::get( 'role_id' );
		$id     = Input::get( 'id' );

		$role = Role::findOrFail($role_id);
		$permission = Permission::findOrFail($id);
		$active     = $role->perms()->where('id',$permission->id)->exists();

		if($active == 1){
			$role->detachPermission($permission);
		} else {
			$role->attachPermission($permission);
		}

		return new JsonResponse( [
			'status'  => 1,
			'message' => $permission->getActiveFullResponse($role)
		], 200 );
	}

	/**
	 * get the specified resource from storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getDeviceSensorsToSelect()
	{
		$device_id = Input::get('id');
		if($device_id  == NULL) return $device_id ;
		return Sensor::where('device_id',$device_id)->active()->get()->map(function($p){
			$p->text = $p->getShortNameScale();
			return $p;
		});
	}
	/**
	 * get the specified resource from storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getSensorSensorType()
	{
		$sensor_id = Input::get('id');
		if($sensor_id  == NULL) return $sensor_id ;
		return Sensor::findOrFail($sensor_id)->sensor_type->getRangeValues();
	}
}
