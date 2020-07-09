<?php
declare (strict_types=1);

namespace App\Services\Enums\UCenter;


use JoyceZ\LaravelLib\Enum\BaseEnum;

/**
 * 用户状态
 *
 * @author joyecZhang <zhangwei762@163.com>
 * Class MemberStateEnum
 * @package App\Services\Enums\UCenter
 */
class MemberStateEnum extends BaseEnum
{
    const USER_STATE_STOP = 0;
    const USER_STATE_ENABLE = 1;

    public static function getMap(): array
    {
        return [
            self::USER_STATE_STOP => '停用',
            self::USER_STATE_ENABLE => '启用'
        ];
    }

}
