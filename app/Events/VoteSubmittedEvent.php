<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoteSubmittedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    protected $topCandidates;

    public function __construct($topCandidates)
    {
        $this->topCandidates = $topCandidates;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('candidates_leaderboard'),
        ];
    }

    public function broadcastAs()
    {
        return 'VoteSubmittedEvent';
    }
    
    public function broadcastWith()
    {
        return [
            'topCandidates' => $this->topCandidates
        ];
    }
}
