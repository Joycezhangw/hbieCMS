<?php


namespace App\Services\Models\System;


use Illuminate\Database\Eloquent\Model;

/**
 * 小程序首页金刚设置
 * Class SysMpPagesModel
 * @package App\Services\Models\System
 */
class SysMpPagesModel extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'sys_mp_pages';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'page_id';

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
        'page_id',
        'page_title',
        'page_icon',
        'page_url',
        'page_sort',
        'is_show',
        'created_at',
        'updated_at'
    ];
}
