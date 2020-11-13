<?php
declare (strict_types=1);

namespace App\Services\Models\Manage;

use Illuminate\Database\Eloquent\Model;

/**
 * 管理员绑定角色
 * Class ManageHasRoleModel
 * @package App\Services\Models\Manage
 */
class ManageHasRoleModel extends Model
{
    protected $table='hb_manage_has_role';

    protected $fillable=[
        'role_id','manage_id'
    ];
}
