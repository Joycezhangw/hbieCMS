<?php
declare (strict_types=1);

namespace App\Services\Repositories\Manage;


use App\Services\Models\Manage\ManageLogModel;
use App\Services\Repositories\Manage\Interfaces\IManageLog;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

/**
 * 实现管理员接口
 * Class ManageLogRepo
 * @package App\Services\Repositories\Manage
 */
class ManageLogRepo extends BaseRepository implements IManageLog
{
    public function __construct(ManageLogModel $model)
    {
        parent::__construct($model);
    }

    /**
     * 日志列表
     * @param array $params
     * @return array
     */
    public function getPageLists(array $params): array
    {
        $lists = $this->model->where(function ($query) use ($params) {
            if (isset($params['search_text']) && $params['search_text'] != '') {
                $query->where('manage_username', 'like', '%' . $params['search_text'] . '%');
            }
            if (isset($params['created_time']) && $params['created_time'] != '') {
                $date = explode('至', $params['created_time']);
                $query->where('created_at', '>=', strtotime(trim($date[0])))->where('created_at', '<=', strtotime(trim($date[1])));
            }
        })
            ->select(['log_id','manage_username','log_title','log_url','log_ip','useragent','created_at'])
            ->orderBy('created_at','desc')
            ->paginate(isset($params['page_size']) ? $params['page_size'] : config('student.paginate.page_size'));
        return $lists->toArray();
    }


}
