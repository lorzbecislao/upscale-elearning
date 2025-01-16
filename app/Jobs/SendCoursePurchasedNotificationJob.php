<?php

namespace App\Jobs;

use App\Models\Lesson;
use App\Notifications\CoursePurchasedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;


class SendCoursePurchasedNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $course;
    protected $email;

    /**
     * Create a new job instance.
     */
    public function __construct(Lesson $course, $email)
    {
        $this->course = $course;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::route('mail', $this->email)->notify(new CoursePurchasedNotification($this->course, $this->email));
    }
}
