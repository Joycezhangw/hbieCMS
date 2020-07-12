<?php


namespace App\Http\Controllers\Manage;


use App\Services\Repositories\CMS\Interfaces\IArticle;
use App\Services\Repositories\CMS\Interfaces\IChannel;
use Illuminate\Http\Request;

class Article extends ManageController
{
    public function index(Request $request, IChannel $channelRepo, IArticle $articleRepo)
    {
        if ($request->ajax()) {

        } else {
            $channels=$channelRepo->all();
            return $this->view(compact('channels'));
        }
    }
}
