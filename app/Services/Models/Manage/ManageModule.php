<?php
declare (strict_types=1);

namespace App\Services\Models\Manage;

use Illuminate\Database\Eloquent\Model;

class ManageModule extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'hb_manage_module';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'module_id';

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

    protected $fillable = [
        'module_id',
        'module_name',
        'module',
        'controller',
        'method',
        'pid',
        'module_level',
        'module_route',
        'is_menu',
        'module_sort',
        'module_desc',
        'module_icon_class',
        'created_at',
        'updated_at',
    ];

}
