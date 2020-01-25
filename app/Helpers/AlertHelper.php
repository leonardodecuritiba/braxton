<?php

namespace App\Helpers;

use App\Models\Clients\Alerts\Alert;
use App\Models\Clients\Alerts\AlertLog;
use Carbon\Carbon;


class AlertHelper {

	static public $_DEBUG_ = 0;
	public $start;
	public $end;
	public $alert;
	public $sensor;
	public $data;
	public $now;


	public function __construct(Alert $alert) {
		$this->alert = $alert;
//		$this->end = clone $this->report->execution_at;
//		$this->start = clone $this->report->execution_at;
//		$this->start->setTime($this->report->getHourBegin(), $this->report->getMinuteBegin());
		$this->sensor = $this->alert->sensor;
		$this->now = Carbon::now();
	}


	// =======================================================
	// ============== REPORT RUN =============================
	// =======================================================

	public function run()
	{
		return $this->checkType();
	}

	public function checkType()
	{
		$response = NULL;
		switch ($this->alert->alert_type){
			case BaseHelper::$_ALERT_TYPE_SENSOR_FAIL_:
				$response = $this->checkSensorFail();
				break;
			case BaseHelper::$_ALERT_TYPE_ENERGY_FAIL_:
				$response = $this->checkEnergyFail();
				break;
			case BaseHelper::$_ALERT_TYPE_INACTIVITY_:
				$response = $this->checkInactivity();
				break;
			case BaseHelper::$_ALERT_TYPE_VALUE_:
				$response = $this->checkValues();
				break;
		}
		return $response;
	}


	// =======================================================
	// ============== INACTIVITY =============================
	// =======================================================

	public function checkInactivity()
	{
		// Alerta Sensor Inativo (definição): É quando um sensor (APARELHO) ficar por um determinado periodo de tempo sem transmitir dados para o sistema.
		// No meu alerta deve ter uma caixa para selecionar Alerta de inatividade e um firulinha para escolher o periodo toleravel ( de 1 a 240 minutos)
		$AlertLog = NULL;

		$t_inactivity = $this->alert->getConditionValues() * 60; //(tempo configurado em segundos)
		$latest_log = $this->alert->getLatestLog(); //Latest log from sensor
		$t_diff = $this->now->getTimestamp() - $latest_log->created_at->timestamp; //(Diferença em segundos de inatividade)

		if ($t_diff > $t_inactivity) {

			$AlertLog = AlertLog::create([
				'alert_id'  => $this->alert->id,
				'data'      => [
					't_diff'    => $t_diff,
					'latest_log'    => $latest_log->created_at->toDateTimeString(),
					'message'       => 'Última atividade registrada em: '. $latest_log->created_at->toDateTimeString(),
				],
			]);

			$AlertLog->notifyInactivity();
		}

		return $AlertLog;
	}

	public function checkInRange()
	{
//		($valor_indicador >= $valores['minimo']) && ($valor_indicador <= $valores['maximo'])
		$response = NULL;
		$latest_log = $this->alert->getLatestLog(); //Latest log from sensor
		$values = $this->alert->getConditionValues();
		if (($latest_log->value >= $values[0]) && ($latest_log->value <= $values[1])) {
			$response = [
				'alert_id'  => $this->alert->id,
				'data'      => [
					'value'         => json_encode($values),
					'latest_log'    => $latest_log->created_at->toDateTimeString(),
					'message'       => 'O valor medido: ' . $latest_log->value . ' está dentro da faixa entre: '.$values[0] . ' e ' . $values[1],
				],
			];
		}
		return $response;

	}

	public function checkOutRange()
	{
		$response = NULL;
		$latest_log = $this->alert->getLatestLog(); //Latest log from sensor
		$values = $this->alert->getConditionValues();
		if (($latest_log->value < $values[0]) || ($latest_log->value > $values[1])) {
			$response = [
				'alert_id'  => $this->alert->id,
				'data'      => [
					'value'         => json_encode($values),
					'latest_log'    => $latest_log->created_at->toDateTimeString(),
					'message'       => 'O valor medido: ' . $latest_log->value . ' está fora da faixa entre: '.$values[0] . ' e ' . $values[1],
				],
			];
		}
		return $response;
	}

	public function checkEqual()
	{
		$response = NULL;
		$latest_log = $this->alert->getLatestLog(); //Latest log from sensor
		$value = $this->alert->getConditionValues();
		if ($latest_log->value == $value) {
			$response = [
				'alert_id'  => $this->alert->id,
				'data'      => [
					'value'         => $value,
					'latest_log'    => $latest_log->created_at->toDateTimeString(),
					'message'       => 'O valor medido é igual a: '.$value,
				],
			];
		}
		return $response;
	}

	public function checkDifferent()
	{
		$response = NULL;
		$latest_log = $this->alert->getLatestLog(); //Latest log from sensor
		$value = $this->alert->getConditionValues();
		if ($latest_log->value != $value) {
			$response = [
				'alert_id'  => $this->alert->id,
				'data'      => [
					'value'         => $value,
					'latest_log'    => $latest_log->created_at->toDateTimeString(),
					'message'       => 'O valor medido: ' . $latest_log->value . ' é diferente de: '.$value,
				],
			];
		}
		return $response;
	}

	public function checkGreater()
	{
		$response = NULL;
		$latest_log = $this->alert->getLatestLog(); //Latest log from sensor
		$value = $this->alert->getConditionValues();
		if ($latest_log->value > $value) {
			$response = [
				'alert_id'  => $this->alert->id,
				'data'      => [
					'value'         => $value,
					'latest_log'    => $latest_log->created_at->toDateTimeString(),
					'message'       => 'O valor medido: ' . $latest_log->value . ' é maior que: '.$value,
				],
			];
		}
		return $response;
	}

	public function checkGreaterEqual()
	{
		$response = NULL;
		$latest_log = $this->alert->getLatestLog(); //Latest log from sensor
		$value = $this->alert->getConditionValues();
		if ($latest_log->value >= $value) {
			$response = [
				'alert_id'  => $this->alert->id,
				'data'      => [
					'value'         => $value,
					'latest_log'    => $latest_log->created_at->toDateTimeString(),
					'message'       => 'O valor medido: ' . $latest_log->value . ' é maior ou igual a: '.$value,
				],
			];
		}
		return $response;
	}

	public function checkLower()
	{
		$response = NULL;
		$latest_log = $this->alert->getLatestLog(); //Latest log from sensor
		$value = $this->alert->getConditionValues();
		if ($latest_log->value < $value) {
			$response = [
				'alert_id'  => $this->alert->id,
				'data'      => [
					'value'         => $value,
					'latest_log'    => $latest_log->created_at->toDateTimeString(),
					'message'       => 'O valor medido: ' . $latest_log->value . ' é menor que: '.$value,
				],
			];
		}
		return $response;
	}

	public function checkLowerEqual()
	{
		$response = NULL;
		$latest_log = $this->alert->getLatestLog(); //Latest log from sensor
		$value = $this->alert->getConditionValues();
		if ($latest_log->value <= $value) {
			$response = [
				'alert_id'  => $this->alert->id,
				'data'      => [
					'value'         => $value,
					'latest_log'    => $latest_log->created_at->toDateTimeString(),
					'message'       => 'O valor medido: ' . $latest_log->value . ' é menor ou igual a: '.$value,
				],
			];
		}
		return $response;

	}

	public function checkValues()
	{
		$AlertLog = NULL;
		switch ($this->alert->condition_type){
			case BaseHelper::$_ALERT_CONDITION_IN_RANGE_:
				$AlertLog = $this->checkInRange();
				break;
			case BaseHelper::$_ALERT_CONDITION_OUT_RANGE_:
				$AlertLog = $this->checkOutRange();
				break;
			case BaseHelper::$_ALERT_CONDITION_EQUAL_:
				$AlertLog = $this->checkEqual();
				break;
			case BaseHelper::$_ALERT_CONDITION_DIFFERENT_:
				$AlertLog = $this->checkDifferent();
				break;
			case BaseHelper::$_ALERT_CONDITION_GREATER_:
				$AlertLog = $this->checkGreater();
				break;
			case BaseHelper::$_ALERT_CONDITION_GREATER_EQUAL_:
				$AlertLog = $this->checkGreaterEqual();
				break;
			case BaseHelper::$_ALERT_CONDITION_LOWER_:
				$AlertLog = $this->checkLower();
				break;
			case BaseHelper::$_ALERT_CONDITION_LOWER_EQUAL_:
				$AlertLog = $this->checkLowerEqual();
				break;
		}

		if($AlertLog != NULL){
			$AlertLog = AlertLog::create($AlertLog);
			$AlertLog->notifyValue();
		}

		return $AlertLog;






		$alertar = NULL;
		$condicao = $this->Alert->condicao['condicao'];
		$valores = $this->Alert->condicao['valores'];
		$indicador = $this->Alert->indicador["valor"];
		$nome_indicador = $this->indicadores[$indicador]['nome'];
		$escala_indicador = $this->indicadores[$indicador]['escala'];
		$valor_indicador = $valores_indicador->{$indicador};

//        dd($nome_indicador);
		echo "***************************************<br>";
		echo "**** ALERTA DE VALOR DO SENSOR  ****<br>";
		echo "***************************************<br>";
		if ($this->debug) echo $indicador . ': ' . $valor_indicador . '<br>';
		if ($this->debug) print_r("condicoes:");
		if ($this->debug) print_r("<pre>");
		if ($this->debug) print_r($condicao);
		if ($this->debug) print_r("</pre>");
		if ($this->debug) print_r("condicoes - valores: " . (json_encode($valores)) . "<br>");

		// checagem do alerta
		switch ($condicao['indice']) {
			case 0: //'0' => 'Dentro da faixa',
//                echo 'CONDIÇÃO: Dentro da faixa <br>';
				if (($valor_indicador >= $valores['minimo']) && ($valor_indicador <= $valores['maximo'])) {
					$mensagem = [
						'title' => 'Alarme - Limite Atingido',
						'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
						'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . " entre: " . implode($escala_indicador . ' e ', $valores) . '.',
					];

					$alertar[] = [
						'sensor_id' => $this->Alert->sensor_id,
						'type' => 'danger',
						'title' => $mensagem['title'],
						'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
						'date' => \Carbon\Carbon::now(),
					];
				}
				break;
			case 1: //'1' => 'Fora da faixa',
//                echo 'CONDIÇÃO: Fora da faixa <br>';
				if (($valor_indicador < $valores['minimo']) || ($valor_indicador > $valores['maximo'])) {
					$mensagem = [
						'title' => 'Alarme - Limite Atingido',
						'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
						'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . " entre: " . implode($escala_indicador . ' e ', $valores) . '.',
					];

					$alertar[] = [
						'sensor_id' => $this->Alert->sensor_id,
						'type' => 'danger',
						'title' => $mensagem['title'],
						'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
						'date' => \Carbon\Carbon::now(),
					];
				}
				break;
			case 2: //'2' => 'Igual a',
//                echo 'CONDIÇÃO: Igual a <br>';
				if ($valor_indicador == $valores) {
					$mensagem = [
						'title' => 'Alarme - Limite Atingido',
						'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
						'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . ": " . $valores . $escala_indicador . '.',
					];

					$alertar[] = [
						'sensor_id' => $this->Alert->sensor_id,
						'type' => 'danger',
						'title' => $mensagem['title'],
						'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
						'date' => \Carbon\Carbon::now(),
					];
				}
				break;
			case 3: //'3' => 'Diferente de',
//                echo 'CONDIÇÃO: Diferente de <br>';
				if ($valor_indicador != $valores) {
					$mensagem = [
						'title' => 'Alarme - Limite Atingido',
						'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
						'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . ": " . $valores . $escala_indicador . '.',
					];

					$alertar[] = [
						'sensor_id' => $this->Alert->sensor_id,
						'type' => 'danger',
						'title' => $mensagem['title'],
						'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
						'date' => \Carbon\Carbon::now(),
					];
				}
				break;
			case 4: //'4' => 'Maior que',
//                echo 'CONDIÇÃO: Maior que <br>';
				if ($valor_indicador > $valores) {
					$mensagem = [
						'title' => 'Alarme - Limite Atingido',
						'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
						'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . ": " . $valores . $escala_indicador . '.',
					];

					$alertar[] = [
						'sensor_id' => $this->Alert->sensor_id,
						'type' => 'danger',
						'title' => $mensagem['title'],
						'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
						'date' => \Carbon\Carbon::now(),
					];
				}
				break;
			case 5: //'5' => 'Maior ou igual a',
//                echo 'CONDIÇÃO: Maior ou igual a <br>';
				if ($valor_indicador >= $valores) {
					$mensagem = [
						'title' => 'Alarme - Limite Atingido',
						'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
						'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . ": " . $valores . $escala_indicador . '.',
					];

					$alertar[] = [
						'sensor_id' => $this->Alert->sensor_id,
						'type' => 'danger',
						'title' => $mensagem['title'],
						'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
						'date' => \Carbon\Carbon::now(),
					];
				}
				break;
			case 6: //'6' => 'Menor que',
//                echo 'CONDIÇÃO: Menor que <br>';
				if ($valor_indicador < $valores) {
					$mensagem = [
						'title' => 'Alarme - Limite Atingido',
						'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
						'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . ": " . $valores . $escala_indicador . '.',
					];

					$alertar[] = [
						'sensor_id' => $this->Alert->sensor_id,
						'type' => 'danger',
						'title' => $mensagem['title'],
						'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
						'date' => \Carbon\Carbon::now(),
					];
				}
				break;
			case 7: //'7' => 'Menor ou igual a'
//                echo 'CONDIÇÃO: Menor ou igual a <br>';
				if ($valor_indicador <= $valores) {
					$mensagem = [
						'title' => 'Alarme - Limite Atingido',
						'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
						'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . ": " . $valores . $escala_indicador . '.',
					];

					$alertar[] = [
						'sensor_id' => $this->Alert->sensor_id,
						'type' => 'danger',
						'title' => $mensagem['title'],
						'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
						'date' => \Carbon\Carbon::now(),
					];
				}
				break;
		}

		if ($this->send_email_sensor) {
			$this->subject = Option::get('text_emails_user_notify_alert_indicator');
		}
		return $alertar;
	}


	public function checkSensorFail()
	{

		return NULL;
		//Alerta Falha de Sensor (definição): É quando um Sensor (APARELHO) apresenta algum tipo de falha interna,
		// erro de circuito, falha de algum sensor (não importa qual), falha eletrônica, etc.
		// Nesse caso ele fica transmitindo o indicador failover=1 e os demais indicadores = NULL


		$latest_log = $this->alert->getLatestLog(); //Latest log from sensor
		if ($t_diff > $t_inactivity) {

			$AlertLog = AlertLog::create([
				'alert_id'  => $this->alert->id,
				'data'      => [
					't_diff'    => $t_diff,
					'latest_log'    => $latest_log->created_at->toDateTimeString(),
				],
			]);

			$AlertLog->notify();
		}


		return NULL;

		//Alerta Falha de Sensor (definição): É quando um Sensor (APARELHO) apresenta algum tipo de falha interna,
		// erro de circuito, falha de algum sensor (não importa qual), falha eletrônica, etc.
		// Nesse caso ele fica transmitindo o indicador failover=1 e os demais indicadores = NULL


		$alertar = NULL;
		if ($valores_indicador->failover == 1) {
			echo "**************************************<br>";
			echo "******* ALERTA FALHA DE SENSOR *******<br>";
			echo "**************************************<br>";
			echo 'failover = ' . $valores_indicador->failover . "<br>";

			$mensagem = [
				'title' => 'Alarme - Falha do Sensor',
				'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
				'body' => 'Houve uma falha no Sensor, isto acontece quando um Sensor apresenta algum tipo de falha interna, erro de circuito, 
                falha de algum sensor interno, falha eletrônica, remoção do microfone.',
			];

			$alertar[] = [
				'sensor_id' => $this->Alert->sensor_id,
				'type' => 'danger',
				'title' => $mensagem['title'],
				'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
				'date' => \Carbon\Carbon::now(),
			];
		}
		if ($this->send_email_sensor) {
			$this->subject = Option::get('text_emails_user_notify_alert_fail');
		}
		return $alertar;
	}

	public function checkEnergyFail()
	{

		return NULL;
		// Alerta Falha de Energia (definição): É quando um sensor (APARELHO) detecta que faltou enegia (alimentação)
		// ele começa a transmitir o indicador failenergy=1, e transmiti os demais indicadores  normalmente,
		// enquanto ainda tem bateria.
		$alertar = NULL;
		if ($valores_indicador->failenergy == 1) {
			echo "**************************************<br>";
			echo "******* ALERTA FALHA DE ENERGIA *******<br>";
			echo "**************************************<br>";
			echo 'failenergy = ' . $valores_indicador->failenergy . "<br>";

			$mensagem = [
				'title' => 'Alarme - Falha de Energia do Sensor',
				'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
				'body' => 'Foi detectada uma queda de energia no Sensor.',
			];

			$alertar[] = [
				'sensor_id' => $this->Alert->sensor_id,
				'type' => 'danger',
				'title' => $mensagem['title'],
				'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
				'date' => \Carbon\Carbon::now(),
			];
		}
		if ($this->send_email_sensor) {
			$this->subject = Option::get('text_emails_user_notify_alert_energy');
		}
		return $alertar;
	}


}
