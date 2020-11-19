<?php
declare (strict_types=1);

namespace App\Services\Repositories\UCenter;


use App\Services\Models\UCenter\MemberModel;
use App\Services\Repositories\UCenter\Interfaces\IMember;
use Illuminate\Support\Facades\DB;
use JoyceZ\LaravelLib\Helpers\DateHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

/**
 * 实现会员管理仓库接口
 * Class MemberRepo
 * @package App\Services\Repositories\UCenter
 */
class MemberRepo extends BaseRepository implements IMember
{

    public function __construct(MemberModel $model)
    {
        parent::__construct($model);
    }

    /**
     * 获取用户列表
     * @param array $params
     * @return array
     */
    public function getPageList(array $params): array
    {
//        DB::connection()->enableQueryLog();
        $lists = $this->model->where(function ($query) use ($params) {
            if (isset($params['search_text_type']) && isset($params['search_text']) && $params['search_text'] != '') {
                if ($params['search_text_type'] == 'username') {
                    $query->where('username', 'like', '%' . $params['search_text'] . '%');
                }
                if ($params['search_text_type'] == 'mobile') {
                    $query->where('user_mobile', 'like', '%' . $params['search_text'] . '%');
                }
                if ($params['search_text_type'] == 'email') {
                    $query->where('user_email', 'like', '%' . $params['search_text'] . '%');
                }
            }

            if (isset($params['created_time']) && $params['created_time'] != '') {
                $date = explode('至', $params['created_time']);
                $query->where('reg_date', '>=', strtotime(trim($date[0])))->where('reg_date', '<=', strtotime(trim($date[1])));
            }
            if (isset($params['status']) && trim($params['status']) != '') {
                $query->where('user_state', intval($params['status']));
            }
        })
            ->select(['uid', 'username', 'nickname', 'realname', 'user_mobile', 'user_email', 'user_avatar', 'user_state', 'reg_ip', 'group_id', 'is_super', 'user_type', 'reg_date', 'last_login_ip', 'last_login_time', 'updated_at'])
            ->paginate(isset($params['page_size']) ? $params['page_size'] : config('student.paginate.page_size'));
//        dd(DB::getQueryLog());
        return $lists->toArray();
    }

    public function parseDataRow(array $row): array
    {
        if (isset($row['reg_date'])) {
            $row['reg_date_txt'] = DateHelper::formatParseTime((int)$row['reg_date']);
            $row['reg_date_ago'] = DateHelper::formatDateLongAgo((int)$row['reg_date']);
        }
        return $row;
    }


}
