<?php


namespace App\Services\Repositories\System;


use App\Services\Models\System\SysMpPagesModel;
use App\Services\Repositories\System\Interfaces\ISysMpPages;
use Illuminate\Support\Facades\Storage;
use JoyceZ\LaravelLib\Helpers\DateHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

/**
 * 实现小程序首页金刚区域
 * Class SysMpPagesRepo
 * @package App\Services\Repositories\System
 */
class SysMpPagesRepo extends BaseRepository implements ISysMpPages
{
    public function __construct(SysMpPagesModel $model)
    {
        parent::__construct($model);
    }

    public function parseDataRow(array $row): array
    {
        if (isset($row['page_icon'])) {
            $row['page_icon_url'] = !empty($row['page_icon']) ? asset(Storage::url($row['page_icon'])) : '';
        }
        if (isset($row['created_at'])) {
            $row['created_at_txt'] = DateHelper::formatParseTime($row['created_at'], 'Y-m-d H:i:s');
        }
        if (isset($row['updated_at'])) {
            $row['updated_at_txt'] = DateHelper::formatParseTime($row['updated_at'], 'Y-m-d H:i:s');
        }
        return $row;
    }
}
