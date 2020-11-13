<?php
declare (strict_types=1);

namespace App\Services\Repositories\CMS;


use App\Services\Models\CMS\ChannelModel;
use App\Services\Repositories\CMS\Interfaces\IChannel;
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
}
