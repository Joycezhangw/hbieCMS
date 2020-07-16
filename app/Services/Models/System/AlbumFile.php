<?php
declare (strict_types=1);

namespace App\Services\Models\System;


use Illuminate\Database\Eloquent\Model;

class AlbumFile extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'sys_album_file';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'file_id';

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
        'file_id',
        'album_id',
        'file_md5',
        'file_name',
        'file_path',
        'file_size',
        'file_ext',
        'file_type',
        'original_name',
        'file_ip',
        'mime_type',
        'created_at',
        'updated_at'
    ];
}
