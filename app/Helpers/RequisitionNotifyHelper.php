<?php

namespace App\Helpers;

use App\Models\Users\Role;
use App\Models\Requisitions\Requisition;
use App\Notifications\approvedCotationRequisitionNotify;
use App\Notifications\closeCotationRequisitionNotify;
use App\Notifications\closeRequisitionNotify;
use App\Notifications\notApprovedCotationRequisitionNotify;

class RequisitionNotifyHelper {

	const DEBUG = 0;
	private $buyers;
	private $coordenators;
	private $managers;
	private $financials;
	private $Requisition;

	function __construct( Requisition $requisition ) {
		$this->Requisition = $requisition;
	}

	public function closeRequisitionNotify() {
		//buyer
		if ( self::DEBUG ) {
			return;
		}
		$this->setBuyers();
		foreach ( $this->buyers as $user ) {
			$user->notify( new closeRequisitionNotify( $this->Requisition, $user->name ) );
		}
	}

	private function setBuyers() {
		$this->buyers = Role::with( 'users' )->where( 'id', 3 )->first()->users;
	}

	public function notApprovedCotationRequisitionNotify() {
		//manager
		if ( self::DEBUG ) {
			return;
		}
		$this->setManagers();
		foreach ( $this->managers as $user ) {
			$user->notify( new notApprovedCotationRequisitionNotify( $this->Requisition, $user->name ) );
		}
	}

	private function setManagers() {
		$this->managers = Role::with( 'users' )->where( 'id', 1 )->first()->users;
	}

	public function closeCotationRequisitionNotify() {
		//buyer
		if ( self::DEBUG ) {
			return;
		}
		$this->setBuyers();
		foreach ( $this->buyers as $user ) {
			$user->notify( new closeCotationRequisitionNotify( $this->Requisition, $user->name ) );
		}
	}

	public function approvedCotationRequisitionNotify() {
		//coordenator, manager
		if ( self::DEBUG ) {
			return;
		}
		$this->setCoordenators();
		$this->setManagers();
		foreach ( $this->coordenators as $user ) {
			$user->notify( new approvedCotationRequisitionNotify( $this->Requisition, $user->name ) );
		}
		foreach ( $this->managers as $user ) {
			$user->notify( new approvedCotationRequisitionNotify( $this->Requisition, $user->name ) );
		}
	}

	private function setCoordenators() {
		$this->coordenators = Role::with( 'users' )->where( 'id', 2 )->first()->users;
	}

	private function setFinancials() {
		$this->financials = Role::with( 'users' )->where( 'id', 4 )->first()->users;
	}

	/*
		public function cancelNegociationNotify()
		{
			if (self::DEBUG) return;
			$this->sendOwnerNotification([
				'error' => 1,
				'subject' => 'ATENÇÃO: A negociação referente ao imóvel ' . $this->Property->id . ' foi cancelada',
				'title' => 'Negociação Cancelada',
				'message' => 'Infelizmente essa negociação precisou ser cancelada, você pode entrar em contato para obter maiores informações.',
				'recomendation' => 'Confira nossos canais de atendimento abaixo:',
				'link' => route('index'),
			]);

			$this->sendRenterNotification([
				'error' => 1,
				'subject' => 'ATENÇÃO: A negociação referente ao imóvel ' . $this->Property->id . ' foi cancelada',
				'title' => 'Negociação Cancelada',
				'message' => 'Infelizmente essa negociação precisou ser cancelada. Vamos tentar novamente?',
				'recomendation' => 'Confira mais oportunidades abaixo:',
				'link' => route('index'),
			]);

			$this->sendAdminsNotification([
				'error' => 1,
				'subject' => 'Negociação cancelada - Imóvel ' . $this->Property->id,
				'title' => 'Negociação Cancelada',
				'message' => 'Negociação Cancelada'
			]);

			return true;
		}
	*/


}