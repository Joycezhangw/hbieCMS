<?php
declare (strict_types=1);

namespace App\Services\Repositories\System;


use App\Services\Models\System\Slide;
use App\Services\Repositories\System\Interfaces\ISlide;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

class SlideRepo extends BaseRepository implements ISlide
{
    public function __construct(Slide $model)
    {
        parent::__construct($model);
    }

    /**
     * 获取幻灯片分页列表
     * @param array $params
     * @return array
     */
    public function getSlidePageList(array $params): array
    {
//        DB::enableQueryLog();
        $lists = $this->model->where(function ($query) use ($params) {
            if (isset($params['search_text']) && $params['search_text'] != '') {
                $query->where('slide_name', 'like', '%' . $params['search_text'] . '%');
            }
            if (isset($params['created_time']) && $params['created_time'] != '') {
                $date = explode('至', $params['created_time']);
                $query->where('created_at', '>=', strtotime(trim($date[0])))->where('created_at', '<=', strtotime(trim($date[1])));
            }
        })->paginate(isset($params['page_size']) ? $params['page_size'] : config('student.paginate.page_size'));
//        dd(DB::getQueryLog());
        return $lists->toArray();
    }


}
