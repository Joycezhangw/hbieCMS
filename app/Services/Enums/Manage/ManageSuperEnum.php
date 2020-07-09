<?php
declare (strict_types=1);

namespace App\Services\Enums\Manage;


use JoyceZ\LaravelLib\Enum\BaseEnum;

/**
 * 是否超级管理员
 * Class ManageSuperEnum
 * @package App\Services\Enums\Manage
 */
class ManageSuperEnum extends BaseEnum
{
    const USER_NO_SUPER = 0;
    const USER_YES_SUPER = 1;


    public static function getMap(): array
    {
        return [
            self::USER_NO_SUPER => '否',
            self::USER_YES_SUPER => '是'
        ];
    }
}
