<?php

namespace App\Events\Listeners;

use App\Events\ManageAction;
use App\Services\Models\Manage\ManageLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use JoyceZ\LaravelLib\Helpers\StrHelper;

class ManageActionLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ManageAction $event
     * @return void
     */
    public function handle(ManageAction $event)
    {
        $log = new ManageLog();
        $log->log_ip = StrHelper::ip2long($event->log_ip);
        $log->manage_id = $event->manage_id;
        $log->manage_username = $event->username;
        $log->log_url = $event->log_url;
        $log->log_title = $event->log_title;
        $log->log_content = json_encode($event->log_content);
        $log->useragent = $event->useragent;
        $log->save();

    }
}
