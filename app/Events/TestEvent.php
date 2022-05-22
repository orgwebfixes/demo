<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TestEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $data;

    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($value)
    {
        $this->data = [
            'power' => $value
        ];
        /*\Log::info($username);
        if (empty($username)) {
            $username = 'guest';
        }
        $this->username = ucwords($username);*/
        //$this->message  = array('item_name' => 'Italian Pizza', 'table_no' => 'A1', 'kitchen_no' => '1', 'event_id' => 1);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        //$this->message  = array('item_name' => 'Italian Pizza', 'table_no' => 'A1', 'kitchen_no' => '1', 'event_id' => 1);
        //return ['message' => $this->message, 'username' => 'ketan'];
        return $this->data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['push-notification'];
    }
}
