<?php
declare (strict_types=1);

namespace App\Services\Models\System;


use Illuminate\Database\Eloquent\Model;

/**
 * 幻灯片
 * Class SlideModel
 * @package App\Services\Models\System
 */
class SlideModel extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'sys_slide';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'slide_id';

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
        'slide_id',
        'slide_name',
        'slide_pic',
        'slide_page',
        'is_show',
        'slide_sort',
        'slide_desc',
        'created_at',
        'updated_at'
    ];
}
