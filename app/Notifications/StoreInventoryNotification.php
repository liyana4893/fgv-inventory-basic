<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StoreInventoryNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $inventory; //tmbh kat sini jugak

    /**
     * Create a new notification instance.
     */
    public function __construct($inventory)
    {
       $this->inventory = $inventory; //edit sini utk dependency noti utk keluarkan apa nama brg
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database']; //hantar kat mail dan dekat dropdown notification jugak
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Thanks for creating an inventory.')
            ->action('Click here to view inventory', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
           'message' => 'You have created an inventory ' . $this->inventory->name,
           'inventory' => $this->inventory,
           'action' => 'View Inventory',
            //
        ];
    }
}
