<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentReceived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $amount;
    protected $balance;
    protected $source;
    protected $code;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($amount,$balance,$source,$code)
    {
        $this->amount = $amount;
        $this->balance = $balance;
        $this->source = $source;
        $this->code = $code;

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
        return (new MailMessage)
            ->subject('Payment Received')
            ->greeting('Hello '.$notifiable->name)
            ->line('Your payment of Ksh. '.$this->amount.' has been received with confirmation code '.$this->code)
            ->line('Your new Pitisha balance is Ksh. '.$this->balance)
            ->line('Click the button below to see your transaction history')
            ->action('Transaction History', "http://139.162.21.82/transactions")
            ->line('Thank you for using Pitisha!');

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
