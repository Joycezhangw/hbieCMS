<?php

namespace App\Services\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'hb_cms_channel';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'channel_id';

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
        'channel_id',
        'channel_name',
        'channel_short_name',
        'pid',
        'channel_sort',
        'is_show',
        'channel_desc',
        'created_at',
        'updated_at'
    ];

}
