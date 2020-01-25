<?php

namespace App\Traits;


trait ActiveTrait {

	public function updateActive()
	{
		$new = ! $this->attributes['active'];
		$this->active = $new;
		$this->save();
		$message = $new ? trans( 'messages.activate', [ 'name' => $this->getShortName() ] ) : trans( 'messages.inactivate', [ 'name' => $this->getShortName() ] );
		return $this->getActiveFullResponse( $message );
	}

	public function getActiveFullResponse( $message = null )
	{
		return [
			'id'               => $this->getAttribute('id'),
			'model'            => get_class($this),
			'message'          => $message,
			'value'            => $this->attributes['active'],
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

	public function disactive()
	{
		$this->active = 0;
		return $this->save();
	}

	public function getActiveText()
	{
		return ( $this->attributes['active'] ) ? 'Ativo' : 'Inativo';
	}

	public function getActiveColor()
	{
		return ( $this->attributes['active'] ) ? 'green' : 'red';
	}

	public function getActiveRowColor()
	{
		return ( $this->attributes['active'] ) ? '' : 'bg-grey';
	}

	public function getActiveBtnColor()
	{
		return ( $this->attributes['active'] ) ? 'default' : 'success';
	}

	public function getActiveBtnIcon()
	{
		return ( $this->attributes['active'] ) ? 'visibility_off' : 'visibility';
	}

	public function getActiveBtnText()
	{
		return ( $this->attributes['active'] ) ? 'Desativar' : 'Ativar';
	}

	public function getActiveUpdateMessage()
	{
		return $this->getShortName() . (( $this->attributes['active'] ) ? ' ativado com sucesso!' : ' desativado com sucesso!');
	}

	public function getActiveUpdateColor()
	{
		return 'alert-success';
	}

	/**
	 * Scope a query to only include active.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeActive($query)
	{
		return $query->where('active', 1);
	}

	/**
	 * Scope a query to only include inactive.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeInactive($query)
	{
		return $query->where('active', 0);
	}

}