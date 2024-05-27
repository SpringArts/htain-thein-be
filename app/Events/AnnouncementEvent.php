<?php

namespace App\Events;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnnouncementEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Announcement $announcement;
    public User $user;

    /**
     * Create a new event instance.
     */
    public function __construct(Announcement $announcement, User $user)
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
