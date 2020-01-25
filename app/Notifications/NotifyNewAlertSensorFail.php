<?php

namespace App\Notifications;

use App\Models\Clients\Alerts\AlertLog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyNewAlertSensorFail extends Notification
{
    use Queueable;

	public $alert_log;
	/**
	 * Create a new notification instance.
	 *
	 * @param  \App\Models\Clients\Alerts\AlertLog $alert_log
	 * @return void
	 */
	public function __construct(AlertLog $alert_log)
	{
		$this->alert_log = $alert_log;
		//
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		$alert = $this->alert_log->alert;
		$instant = $this->alert_log->getCreatedAtFormatted();
		$url = route('alerts.edit',$alert->id);
		return (new MailMessage)
			->error()
			->subject('Alerta - Falha de Sensor!')
			->greeting('Olá.')
			->line('Sensor: '. $alert->getSensorName())
			->line('Apresentou uma falha em '. $instant)
			->action('Visualizar Alerta', $url);
	}

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
