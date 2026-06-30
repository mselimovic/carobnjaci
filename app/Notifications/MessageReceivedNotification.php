<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MessageReceivedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Message $message,
        protected string $conversationUrl,
    ) {}

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
        $sender = $this->message->sender?->name ?? 'Someone';
        $subject = $this->message->subject ?: 'New message';
        $line = $this->message->product
            ? "Product: {$this->message->product->title}"
            : 'Shop inquiry';

        return (new MailMessage)
            ->subject("Carobnjaci: {$subject}")
            ->greeting("Hello {$notifiable->name},")
            ->line("{$sender} sent you a new message on Carobnjaci.")
            ->line($line)
            ->line($this->message->message)
            ->action('Open conversation', url($this->conversationUrl))
            ->line('Reply from your inbox to keep the conversation going.');
    }
}
