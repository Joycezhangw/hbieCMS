<?php

namespace App\Events\Listeners;

use App\Events\ManageAction;
use App\Services\Repositories\Manage\Interfaces\IManageLog;
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
        $IManageLogRepo = app(IManageLog::class);
        $IManageLogRepo->doCreate([
            'log_ip' => StrHelper::ip2long($event->log_ip),
            'manage_id' => $event->manage_id,
            'manage_username' => $event->username,
            'log_url' => $event->log_url,
            'log_title' => $event->log_title,
            'log_content' => json_encode($event->log_content),
            'useragent' => $event->useragent
        ]);

    }
}
