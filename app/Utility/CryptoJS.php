<?php


namespace App\Utility;

/**
 * 前端 CryptoJS  密码解密
 * Class CryptoJS
 * @package App\Utility
 */
class CryptoJS
{
    const OPENSSL_KEY = '3OXdRYG3v3neV502Yr0PbObt';
    const OPENSSL_IV = 'BKwsl6WGZR8CzV2N';

    public static function opensslDecrypt(string $encrypt, string $method = 'AES-192-CBC')
    {
        $replace = ['+', '/'];
        $search = ['-', '_'];
        $str = openssl_decrypt(str_replace($search, $replace, $encrypt), $method, self::OPENSSL_KEY, OPENSSL_ZERO_PADDING, self::OPENSSL_IV);
        return self::special_filter(trim($str));
    }


    /**
     * 根据ascii码过滤控制字符
     * @param $string
     * @return string
     */
    private static function special_filter($string)
    {
        if (!$string) return '';
        $new_string = '';
        for ($i = 0; isset($string[$i]); $i++) {
            $asc_code = ord($string[$i]);    //得到其asc码
            //以下代码旨在过滤非法字符
            if ($asc_code == 9 || $asc_code == 10 || $asc_code == 13) {
                $new_string .= ' ';
            } else if ($asc_code > 31 && $asc_code != 127) {
                $new_string .= $string[$i];
            }
        }
        return trim($new_string);
    }
}
