<?php


namespace App\Utility;


use Illuminate\Support\Facades\Storage;
use JoyceZ\LaravelLib\Helpers\DateHelper;

class Format
{

    /**
     * 格式化返回视图内容
     * @param array $params
     * @return array
     */
    public static function formatReturnDataByOneDim(array $params)
    {
        if (isset($params['created_at'])) {
            $params['created_at_txt'] = DateHelper::formatParseTime((int)$params['created_at']);
            $params['created_at_ago'] = DateHelper::formatDateLongAgo((int)$params['created_at']);
        }
        if (isset($params['reg_date'])) {
            $params['reg_date_txt'] = DateHelper::formatParseTime((int)$params['reg_date']);
            $params['reg_date_ago'] = DateHelper::formatDateLongAgo((int)$params['reg_date']);
        }
        if (isset($params['updated_at'])) {
            $params['updated_at_txt'] = DateHelper::formatParseTime((int)$params['updated_at']);
        }
        //TODO：多种业务都需要单张图片的数据格式的时候，尽量统一命名，可免除这种多个判断的结果
        if (isset($params['post_pic'])) {
            $params['post_pic_url'] = asset(Storage::url($params['post_pic']));
        }
        if (isset($params['user_avatar'])) {
            $params['user_avatar_url'] = self::buildAvatarUrl($params['user_avatar']);
        }
        if (isset($params['slide_pic'])) {
            $params['slide_pic_url'] = asset(Storage::url($params['slide_pic']));
        }
        if (isset($params['file_path'])) {
            $params['file_path_url'] = asset(Storage::url($params['file_path']));
        }
        if (isset($params['post_tags'])) {
            $params['post_tags_arr'] = explode(',', $params['post_tags']);
        }
        return $params;
    }

    /**
     * 格式化返回视图列表内容
     * @param array $params
     * @return array
     */
    public static function formatReturnDataByManyDim(array $params)
    {
        $data = [];
        foreach ($params as $item) {
            $data[] = static::formatReturnDataByOneDim($item);
        }
        return $data;
    }

    /**
     * 生成图片url地址
     * @param string $img
     * @param string $default
     * @return string
     */
    public static function buildAvatarUrl(string $img = '', string $default = '')
    {
        if (!empty ($img)) {
            if (preg_match('/(http:\/\/)|(https:\/\/)/i', $img)) {
                return $img; // 直接粘贴地址
            } else {
                return asset(Storage::url($img));
            }
        } else {
            if (empty ($default)) {
                return asset('/static/images/default-avatar.png');
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
