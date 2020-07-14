<?php
declare (strict_types=1);

namespace App\Services\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
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
