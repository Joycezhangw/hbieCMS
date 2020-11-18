<?php


namespace App\Services\Models\System;


use Illuminate\Database\Eloquent\Model;

/**
 * 行政区域划分
 * Class SysDistrictModel
 * @package App\Services\Models\System
 */
class SysDistrictModel extends Model
{
    protected $table = 'sys_district';

    /**
     * 指示是否自动维护时间戳
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'district_id',
        'parent_id',
        'depth',
        'name',
        'fullname',
        'pinyin',
        'pinyin_arr',
        'latitude',
        'longitude',
    ];
}
