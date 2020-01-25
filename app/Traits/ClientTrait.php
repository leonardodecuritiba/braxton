<?php

namespace App\Traits;


use App\Models\Clients\Client;
trait ClientTrait {


	public function getClientName()
	{
		return $this->client->getShortName();
	}
	public function client()
	{
		return $this->belongsTo(Client::class, 'client_id');
	}


}