<?php
declare (strict_types=1);

namespace App\Services\Models\Manage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * 管理员角色
 * Class ManageRoleModel
 * @package App\Services\Models\Manage
 */
class ManageRoleModel extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'hb_manage_role';

    protected $primaryKey = 'role_id';

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

    protected $fillable = ['role_id', 'role_title', 'is_default', 'role_desc', 'created_at', 'updated_at'];

    /**
     * 多对多关联权限菜单
     * @return BelongsToMany
     */
    public function rules(): BelongsToMany
    {
        return $this->belongsToMany(ManageModuleModel::class, 'hb_manage_role_has_module', 'role_id', 'module_id');
    }
}
