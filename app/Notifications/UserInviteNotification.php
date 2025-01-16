<?php

namespace App\Notifications;

use App\Mail\UserInviteMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserInviteNotification extends Notification
{
    use Queueable;

    private $user;
    private $generated_password;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, $generated_password)
    {
        $this->user = $user;
        $this->generated_password = $generated_password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function viaQueues(): array
    {
        return [
            'mail' => 'email'
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): UserInviteMail
    {
        $mailable = new UserInviteMail($this->user, $this->generated_password);

        if (config('app.env') == 'production' || config('app.env') == 'uat') {
            $mailable->to($notifiable->email);
        } else {
            $mailable->to(config('mail.test_recipient'));
        }

        return $mailable;
       
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
