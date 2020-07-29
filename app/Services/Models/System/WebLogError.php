<?php

namespace App\Services\Models\System;

use Illuminate\Database\Eloquent\Model;

class WebLogError extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'sys_web_log_error';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'error_id';

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
        'error_id',
        'message',
        'source',
        'lineno',
        'colno',
        'stack',
        'href',
        'created_at',
        'updated_at'
    ];
}
