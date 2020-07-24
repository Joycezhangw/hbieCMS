<?php
declare (strict_types=1);

namespace App\Services\Repositories\UCenter;


use App\Services\Models\UCenter\MemberGroup;
use App\Services\Repositories\UCenter\Interfaces\IMemberGroup;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

/**
 * 实现用户组接口
 * Class MemberGroupRepo
 * @package App\Services\Repositories\UCenter
 */
class MemberGroupRepo extends BaseRepository implements IMemberGroup
{
    public function __construct(MemberGroup $model)
    {
        parent::__construct($model);
    }

    /**
     * 获取用户组
     * @return array
     */
    public function getAllList(): array
    {
        $list = $this->all([], ['group_id', 'group_title', 'group_type', 'is_system', 'is_default']);
        $groups = [];
        foreach ($list as $item) {
            $groups[$item->group_id] = $item->toArray();
        }
        return $groups;
    }


}
