<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecordDespenseMedicine
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $patient_id;
    public $despensed_medicine;
    public $medicine_quantity;
    /**
     * Create a new event instance.
     */
    public function __construct($p_id, $d_meds, $meds_n)
    {
        $this->patient_id = $p_id;
        $this->despensed_medicine = $d_meds;
        $this->medicine_quantity = $meds_n;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
