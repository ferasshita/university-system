<?php

namespace App\Services;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class NotificationService
{
    /**
     * @var \Illuminate\Notifications\ChannelManager
     */
    protected ChannelManager $channels;

    public function __construct(ChannelManager $channels)
    {
        $this->channels = $channels;
    }

    /**
     * Send a notification (or many) to one or many notifiable entities.
     *
     * @param  \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Model|array  $notifiables
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send(array|object $notifiables, Notification $notification): void
    {
        $this->channels->send($notifiables, $notification);
    }

    /**
     * Convenience method for sending immediately to a single notifiable.
     */
    public function sendTo($notifiable, Notification $notification): void
    {
        $this->channels->send($notifiable, $notification);
    }
}
