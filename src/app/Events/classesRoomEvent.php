<?php

namespace App\Events;

use App\Message;
use App\Slides;
use App\Classes;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class classesRoomEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

//    public $slides;
    public $room_id;
//    public $index;
//    public $user;

    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message, $room_id)
    {
        $this->room_id = $room_id;
        $this->message = $message;
    }


//    public function delete($index, $room_id){
//        $this->index = $index;
//        $this->room_id = $room_id;
//    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
//        $class = Classes::find(1);
//        $class->active_member_count = $count->members->count;
//        $class->save();

        return new PresenceChannel('classesroom_'.strval($this->room_id));
//        return new PresenceChannel('classesroom');

    }
}
