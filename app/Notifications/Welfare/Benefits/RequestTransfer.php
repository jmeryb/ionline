<?php

namespace App\Notifications\Welfare\Benefits;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Welfare\Benefits\Request;
use App\Models\Parameters\Parameter;

class RequestTransfer extends Notification implements ShouldQueue
{
    use Queueable;

    protected $request;
    protected $payed_amount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Request $request, $payed_amount)
    {
        $this->request = $request;
        $this->payed_amount = $payed_amount;
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
        $cc_mails = explode(', ', Parameter::get('welfare: beneficios','correos transferido'));

        $payed_amount = $this->payed_amount;
        return (new MailMessage)
                ->level('info')
                ->subject('Confirmación de transferencia de beneficio')
                ->greeting('Hola ' . $notifiable->shortName)
                ->line('Se informa transferencia de beneficio ' . $this->request->subsidy->name . '.')
                ->line('El monto transferido corresponde a $' . $payed_amount)
                ->cc($cc_mails)
                ->salutation('Saludos cordiales.');
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
