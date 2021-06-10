<?php


namespace App\Utility;

/**
 * 前端 CryptoJS  密码解密
 * Class CryptoJS
 * @package App\Utility
 */
class CryptoJS
{
    public static function opensslDecrypt(string $encrypt, string $key, string $iv = '', string $method = 'AES-192-CBC')
    {
        $replace = ['+', '/'];
        $search = ['-', '_'];
        $str = openssl_decrypt(str_replace($search, $replace, $encrypt), $method, $key, OPENSSL_ZERO_PADDING, $iv);
        return trim($str);
    }
}
