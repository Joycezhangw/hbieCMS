<?php
declare (strict_types=1);


namespace App\Services\Repositories\System;


use App\Services\Models\System\WebLogError;
use App\Services\Repositories\System\Interfaces\IWebLogError;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

/**
 * 实现前端错误日志逻辑
 * Class WebLogErrorRepo
 * @package App\Services\Repositories\System
 */
class WebLogErrorRepo extends BaseRepository implements IWebLogError
{
    public function __construct(WebLogError $model)
    {
        parent::__construct($model);
    }
}
