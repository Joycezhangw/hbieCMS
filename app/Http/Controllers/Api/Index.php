<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\Repositories\CMS\Interfaces\IArticle;
use App\Services\Repositories\System\Interfaces\ISlide;
use App\Utility\Format;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class Index extends Controller
{

    public function index(IArticle $articleRepo, ISlide $slideRepo)
    {
        $channels = $articleRepo->getHomeListData();
        $slideData = $slideRepo->all(['is_show' => 1], ['slide_id', 'slide_name', 'slide_pic', 'slide_page'], 'slide_sort');
        $slider =  $slideRepo->parseDataRows($slideData->toArray());
        return ResultHelper::returnFormat('success', 200, compact('slider','channels'));
    }

}
