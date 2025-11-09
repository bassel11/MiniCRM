<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FollowUpDueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $followUp;
    public function __construct($followUp)
    {
        $this->followUp = $followUp;
    }


    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Follow-up Reminder')
            ->line('You have a follow-up scheduled for today.')
            ->line('Client: ' . $this->followUp->client->name)
            ->line('Notes: ' . $this->followUp->notes)
            ->action('View Client', url('/clients/' . $this->followUp->client_id));
    }


    public function toArray(object $notifiable): array
    {
        return [
            'client' => $this->followUp->client->name,
            'due_at' => $this->followUp->due_at,
            'notes' => $this->followUp->notes,
        ];
    }
}
