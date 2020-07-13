<?php
declare (strict_types=1);

namespace App\Services\Models\System;


use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'sys_album';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'album_id';

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
        'album_id',
        'album_name',
        'album_cover',
        'pid',
        'album_sort',
        'is_default',
        'created_at',
        'updated_at'
    ];
}
