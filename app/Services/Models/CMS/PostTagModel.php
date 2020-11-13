<?php
declare (strict_types=1);

namespace App\Services\Models\CMS;

use Illuminate\Database\Eloquent\Model;

/**
 * 内容关联标签
 * Class PostTagModel
 * @package App\Services\Models\CMS
 */
class PostTagModel extends Model
{
    protected $table='hb_cms_post_tag';

    /**
     * 指示是否自动维护时间戳
     * @var bool
     */
    public $timestamps = false;

    protected $fillable=[
        'tag_id','post_id'
    ];
}
