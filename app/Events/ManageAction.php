<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ManageAction
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $manage_id;
    public $username;
    public $log_url;
    public $log_title;
    public $log_content;
    public $log_ip;
    public $useragent;

    /**
     * ManageAction constructor.
     * @param int $manage_id
     * @param string $username
     * @param string $log_url
     * @param string $log_title
     * @param $log_content
     * @param $log_ip
     * @param $useragent
     */
    public function __construct(int $manage_id,string $username,string $log_url,string $log_title,$log_content,$log_ip,$useragent)
    {
        $this->manage_id=$manage_id;
        $this->username=$username;
        $this->log_url=$log_url;
        $this->log_title=$log_title;
        $this->log_content=$log_content;
        $this->log_ip=$log_ip;
        $this->useragent=$useragent;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
