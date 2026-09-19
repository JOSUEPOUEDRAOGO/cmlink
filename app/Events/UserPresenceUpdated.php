<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPresenceUpdated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public int $online;

    public function __construct(int $online)
    {
        $this->online = $online;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin-presence'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'presence.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'online' => $this->online,
        ];
    }
}
