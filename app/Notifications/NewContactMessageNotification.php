<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessageNotification extends Notification
{
    use Queueable;

    public $contactMessage;

    public function __construct($contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Contact Message Received')
            ->line('You have received a new contact message.')
            ->line('Name: ' . $this->contactMessage->name)
            ->line('Email: ' . $this->contactMessage->email)
            ->line('Subject: ' . $this->contactMessage->subject)
            ->line('Message: ' . $this->contactMessage->message)
            ->action('View in Admin Panel', 'http://localhost:3000/messages')
            ->line('This is an automated notification.');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}