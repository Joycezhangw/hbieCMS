<?php


namespace App\Services\Enums\UCenter;


use JoyceZ\LaravelLib\Enum\BaseEnum;

class MemberSuperEnum extends BaseEnum
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
