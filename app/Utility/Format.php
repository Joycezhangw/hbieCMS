<?php


namespace App\Utility;


use Illuminate\Support\Facades\Storage;
use JoyceZ\LaravelLib\Helpers\DateHelper;

class Format
{
    /**
     * 图片默认值
     * @param string $img 图片路径
     * @param string $default 默认图片路径
     * @param bool $isAvatar 是否头像
     * @return string
     */
    public static function buildPictureUrl(string $img = '', bool $isAvatar = false, string $default = '')
    {
        if (!empty ($img)) {
            if (preg_match('/(http:\/\/)|(https:\/\/)/i', $img)) {
                return $img; // 直接粘贴地址
            } else {
                return asset(Storage::url($img));
            }
        } else {
            if (empty ($default)) {
                return $isAvatar ? asset('/static/images/default-avatar.png') : asset('/static/images/pic_empty.png');
            } else {
                if (preg_match('/(http:\/\/)|(https:\/\/)/i', $default)) {
                    return $default; // 直接粘贴地址
                } else {
                    return asset(Storage::url($default));
                }
            }
        }
    }

}
