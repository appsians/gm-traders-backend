<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
       // Log::info('✅ Event class constructed', ['message' => $message]);
    }

    public function broadcastOn()
    {
       //  Log::info('📡 Broadcasting to channel: chat-channel');
        return new Channel('my-channel');
    }

    public function broadcastAs()
    {
         return 'my-event';

        //     Log::info('📡 Broadcasting to channel: chat-channel');
        // return 'message.sent';
    }
}
