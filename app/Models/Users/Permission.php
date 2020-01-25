<?php

namespace App\Models\Users;

use App\Traits\CommonTrait;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
	use CommonTrait;
	private $active;

	public function getMapList(Role $role) {
		return [
			'entity'          => 'permissions',
			'id'              => $this->id,
			'active'          => $this->getActiveFullResponse($role),
			'code'            => $this->name,
			'name'            => trans('global.'.$this->display_name)
		];
	}

	public function getActiveFullResponse(Role $role)
	{
		$this->active = $role->perms()->where('id',$this->id)->exists() ? 1 : 0;
		return [
			'message'          => '',
			'value'            => $this->active,
			'active_text'      => $this->getActiveText(),
			'active_color'     => $this->getActiveColor(),
			'active_row_color' => $this->getActiveRowColor(),
			'active_btn_color' => $this->getActiveBtnColor(),
			'active_btn_icon'  => $this->getActiveBtnIcon(),
			'active_btn_text'  => $this->getActiveBtnText(),
			'active_update_message'  => $this->getActiveUpdateMessage(),
			'active_update_color'  => $this->getActiveUpdateColor(),
		];
	}

	public function getShortName()
	{
		return 'Permissão';
	}

	public function getActiveText()
	{
		return ( $this->active ) ? 'Ativa' : 'Inativa';
	}

	public function getActiveColor()
	{
		return ( $this->active ) ? 'green' : 'red';
	}

	public function getActiveRowColor()
	{
		return ( $this->active ) ? '' : 'bg-grey';
	}

	public function getActiveBtnColor()
	{
		return ( $this->active ) ? 'default' : 'success';
	}

	public function getActiveBtnIcon()
	{
		return ( $this->active ) ? 'radio_button_unchecked' : 'radio_button_checked';
	}

	public function getActiveBtnText()
	{
		return ( $this->active ) ? 'Desativar' : 'Ativar';
	}

	public function getActiveUpdateMessage()
	{
		return $this->getShortName() . (( $this->active ) ? ' ativada com sucesso!' : ' desativada com sucesso!');
	}

	public function getActiveUpdateColor()
	{
		return 'alert-success';
	}

}