<?php


namespace App\Http\Controllers\Manage;


use App\Services\Repositories\CMS\Interfaces\IChannel;

class Channel extends ManageController
{
    public function index(IChannel $channelRepo)
    {
        $channels = $channelRepo->all();
        return $this->view(compact('channels'));
    }

    public function create()
    {
        return $this->view();
    }
}
