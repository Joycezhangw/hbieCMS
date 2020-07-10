<?php

namespace App\Services\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class PostData extends Model
{
    protected $table = 'hb_cms_post_data';

    protected $primaryKey = 'post_id';

    //自动维护时间戳
    public $timestamps = false;


    protected $fillable = ['post_id','content'];
}
