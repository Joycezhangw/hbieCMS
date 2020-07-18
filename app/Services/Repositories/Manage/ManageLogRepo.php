<?php
declare (strict_types=1);

namespace App\Services\Repositories\Manage;


use App\Services\Models\Manage\ManageLog;
use App\Services\Repositories\Manage\Interfaces\IManageLog;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

class ManageLogRepo extends BaseRepository implements IManageLog
{
    public function __construct(ManageLog $model)
    {
        parent::__construct($model);
    }
}
