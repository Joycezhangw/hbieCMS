<?php

namespace App\Services\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'hb_cms_tag';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'tag_id';

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
        'tag_id',
        'tag_name',
        'post_num',
        'created_at',
        'updated_at'
    ];
}
