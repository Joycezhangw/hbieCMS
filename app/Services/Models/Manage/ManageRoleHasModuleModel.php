<?php
declare (strict_types=1);

namespace App\Services\Models\Manage;

use Illuminate\Database\Eloquent\Model;

/**
 * 管理员角色绑定菜单栏目
 * Class ManageRoleHasModuleModel
 * @package App\Services\Models\Manage
 */
class ManageRoleHasModuleModel extends Model
{
    protected $table='hb_manage_role_has_module';

    protected $fillable=[
        'role_id','module_id'
    ];
}
