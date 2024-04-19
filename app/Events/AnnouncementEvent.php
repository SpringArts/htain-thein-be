<?php

namespace App\Events;

use App\Models\Announcement;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class AnnouncementEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $announcement;
    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct(Announcement $announcement, $user)
    {
        $this->announcement = $announcement;
        $this->user = $user;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('announcement-channel'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'announcement-event';
    }
}
