<?php


namespace App\Services\Repositories\System;


use App\Services\Models\System\SysDistrictModel;
use App\Services\Repositories\System\Interfaces\IDistrict;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

/**
 * 实现行政区域划分接口
 * Class DistrictRepo
 * @package App\Services\Repositories\System
 */
class DistrictRepo extends BaseRepository implements IDistrict
{
    public function __construct(SysDistrictModel $model)
    {
        parent::__construct($model);
    }

    public function parseDataRow(array $row): array
    {
        if (isset($row['pinyin_arr'])) {
            $row['pinyin_arr'] = $row['pinyin_arr'] != '' ? explode(',', $row['pinyin_arr']) : [];
        }
        if (isset($row['latitude']) && isset($row['longitude'])) {
            $row['location'] = ['lat' => $row['latitude'], 'lng' => $row['longitude']];
        }
        return $row;
    }
}
