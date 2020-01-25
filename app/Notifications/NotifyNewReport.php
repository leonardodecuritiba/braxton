<?php

namespace App\Notifications;

use App\Models\Clients\Reports\ReportLog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyNewReport extends Notification
{
    use Queueable;

    public $report_log;
    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Clients\Reports\ReportLog $report_log
     * @return void
     */
    public function __construct(ReportLog $report_log)
    {
    	$this->report_log = $report_log;
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
    	$report = $this->report_log->report;
    	$url = route('reports_logs.show',$this->report_log);
        return (new MailMessage)
	        ->success()
            ->subject('Seu Relatório Agendado está pronto!')
            ->greeting('Olá.')
            ->line('O Relatório: '. $report->getName() . ' está pronto!')
            ->line('Clique no link abaixo para visualizá-lo.')
            ->action('Visualizar Relatório', $url);
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
