<?php
declare (strict_types=1);

namespace App\Services\Models\UCenter;


use Illuminate\Database\Eloquent\Model;

/**
 * 用户组
 * Class MemberGroup
 * @package App\Services\Models\UCenter
 */
class MemberGroup extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'uc_member_group';

    protected $primaryKey = 'group_id';

    /**
     * 指示是否自动维护时间戳
     * @var bool
     */
    public $timestamps = true;

    /**
     * 模型日期列的存储格式。
     * @var string
     */
    protected $dateFormat = 'U';

    protected $fillable = ['group_id', 'group_title', 'group_type', 'is_system', 'is_default', 'group_remark', 'created_at', 'updated_at'];

    /**
     * 用户组所对应的用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class);
    }
}
