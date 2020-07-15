<?php
declare (strict_types=1);

namespace App\Services\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'hb_cms_post';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'post_id';

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
        'post_id',
        'post_title',
        'channel_id',
        'channel_ids_path',
        'channel_name_path',
        'manage_id',
        'manage_username',
        'author_uid',
        'author_username',
        'post_tags',
        'post_pic',
        'post_desc',
        'post_like',
        'post_dislike',
        'post_view',
        'post_view',
        'post_fav',
        'post_comment',
        'is_comment',
        'is_guest',
        'is_home_rec',
        'post_status',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * 关联内容 编辑器内容
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function content()
    {
        return $this->hasOne(PostData::class, 'post_id', 'post_id');
    }
}
