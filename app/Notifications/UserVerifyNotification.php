<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class UserVerifyNotification extends VerifyEmail  implements ShouldQueue
{
    use Queueable;
    public $user;      

    /**
     * Create a new notification instance.
     */
    public function __construct($user='')
    {
        $this->user =  $user ?: Auth::user();         //if user is not supplied, get from session
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $actionUrl  = $this->verificationUrl($notifiable);     //verificationUrl required for the verification link
        $actionText  = 'Click here to verify your email';
        return (new MailMessage)->subject('Verify your account')->markdown(
            'emails.user-verify',
            [
                'user'=> $this->user,
                'actionText' => $actionText,
                'actionUrl' => $actionUrl,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
