<?php
declare (strict_types=1);

namespace App\Services\Repositories\Manage\Interfaces;


use JoyceZ\LaravelLib\Repositories\Interfaces\BaseInterface;

/**
 * 管理员
 * Interface IManage
 * @package App\Services\Repositories\Manage\Interfaces
 */
interface IManage extends BaseInterface
{

    /**
     * 管理员登录
     * @param string $username 登录名
     * @param string $password 密码
     * @param string $captcha  验证码
     * @param string $clientIp 客户端ip
     * @return array
     */
    public function doLogin(string $username, string $password, string $captcha,string $clientIp): array;

}
