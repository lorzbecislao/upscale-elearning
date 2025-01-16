<?php

namespace App\Notifications;

use App\Models\Lesson;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CoursePurchasedNotification extends Notification
{
    use Queueable;

    public $course;
    public $email;

    /**
     * Create a new notification instance.
     */
    public function __construct(Lesson $course, $email)
    {
        $this->course = $course;
        $this->email = $email;
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

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = 'A copy of ' . $this->course->name . ' has been purchased by ' . $this->email . '.';
        return (new MailMessage)
                    ->subject('Course Purchased')
                    ->greeting('Hello, Admin')
                    ->line($message)
                    ->line('Thank you!');
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
