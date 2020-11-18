<?php
declare (strict_types=1);

namespace App\Services\Repositories\CMS;


use App\Services\Models\CMS\ChannelModel;
use App\Services\Repositories\CMS\Interfaces\IChannel;
use Illuminate\Support\Facades\Storage;
use JoyceZ\LaravelLib\Helpers\DateHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

/**
 * CMS 栏目仓库接口实现
 *
 * @author joyecZhang <zhangwei762@163.com>
 * Class ChannelRepo
 * @package App\Services\Repositories\CMS
 */
class ChannelRepo extends BaseRepository implements IChannel
{
    public function __construct(ChannelModel $model)
    {
        parent::__construct($model);
    }

    public function parseDataRow(array $row): array
    {
        if (isset($row['channel_icon'])) {
            $row['channel_icon_url'] = !empty($row['channel_icon']) ? asset(Storage::url($row['channel_icon'])) : '';
        }
        if (isset($row['created_at'])) {
            $row['created_at_txt'] = DateHelper::formatParseTime((int)$row['created_at']);
            $row['created_at_ago'] = DateHelper::formatDateLongAgo((int)$row['created_at']);
        }
        return $row;
    }
}
