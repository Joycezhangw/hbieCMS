<?php
declare (strict_types=1);

namespace App\Services\Models\CMS;

use Illuminate\Database\Eloquent\Model;

/**
 * 内容富文本西悉尼
 * Class PostDataModel
 * @package App\Services\Models\CMS
 */
class PostDataModel extends Model
{
    protected $table = 'hb_cms_post_data';

    protected $primaryKey = 'post_id';

    //自动维护时间戳
    public $timestamps = false;


    protected $fillable = ['post_id','content'];
}
