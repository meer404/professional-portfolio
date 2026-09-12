<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly ContactMessage $contactMessage)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New portfolio contact message from '.$this->contactMessage->name)
            ->greeting('New message from your portfolio site')
            ->line('Name: '.$this->contactMessage->name)
            ->line('Email: '.$this->contactMessage->email)
            ->line('Message:')
            ->line($this->contactMessage->message)
            ->action('View in admin', url('/admin/contact-messages/'.$this->contactMessage->id));
    }
}
