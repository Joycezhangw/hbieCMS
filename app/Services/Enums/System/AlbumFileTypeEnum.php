<?php
declare (strict_types=1);

namespace App\Services\Enums\System;


use JoyceZ\LaravelLib\Enum\BaseEnum;

/**
 * 专辑附件类型
 * Class AlbumFileTypeEnum
 * @package App\Services\Enums\System
 */
class AlbumFileTypeEnum extends BaseEnum
{
    const FILE_TYPE = ['image', 'video', 'doc'];

    const ALBUM_FILE_TYPE_IMAGE = 'image';
    const ALBUM_FILE_TYPE_VIDEO = 'video';
    const ALBUM_FILE_TYPE_DOC = 'doc';

    public static function getMap(): array
    {
        return [
            self::ALBUM_FILE_TYPE_IMAGE => '图片',
            self::ALBUM_FILE_TYPE_VIDEO => '视频',
            self::ALBUM_FILE_TYPE_DOC => '文档',
        ];
    }

}
