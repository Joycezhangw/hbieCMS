<?php
declare (strict_types=1);

namespace App\Services\Models\CMS;

use Illuminate\Database\Eloquent\Model;

/**
 * 内容标签
 * Class TagModel
 * @package App\Services\Models\CMS
 */
class TagModel extends Model
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

    /**
     * 创建标签
     * @param string $name
     * @param int $iid
     */
    public static function doSaveTag(string $name,int $iid)
    {
        $tag = TagModel::firstOrCreate(['tag_name' => $name]);
        if ($tag) {
            $tag_id = $tag->tag_id;
            if (!PostTagModel::where(['tag_id' => $tag_id, 'post_id' => $iid])->first()) {
                $tag->increment('post_num');
            }
            PostTagModel::firstOrCreate(['tag_id' => $tag_id, 'post_id' => $iid]);
        }
    }
}
