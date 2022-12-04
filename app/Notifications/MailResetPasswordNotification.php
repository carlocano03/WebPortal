<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MailResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $token;
    public function __construct($token) {
       $this->token = $token;
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
     $resetUrl = url(config('app.url').route('password.reset', $this->token, false));
     $firstName = $notifiable->first_name;
     return ( new MailMessage )
     ->greeting('Hello')
     ->line('You are receiving this email because we received a password reset request for your account.')
     ->action('Reset Password', url(config('app.url').route('password.reset', $this->token, false)).'?email='.$notifiable->email)
     ->line('If you did not request a password reset, no further action is required.')
     ->from('information@upprovidentfund.com', 'UP Provident Fund Inc.')
     ->subject( 'Reset your password' );
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
