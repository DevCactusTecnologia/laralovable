<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

final class AccountCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function broadcastOn(): Channel|array
    {
        return new PrivateChannel('channel-name');
    }
}
