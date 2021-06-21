<?php


namespace App\Traits;

use Illuminate\Support\Facades\Validator;

/**
 * 自定义表单验证
 * Trait ValidatorTrait
 * @package App\Traits
 */
trait ValidatorTrait
{
    public function validatorBoot()
    {
        //扩展验证规则
        //验证手机号
        //TODO：小写扩展 rule，否则自定义的 $member 无效
        Validator::extend('mobile', function ($attribute, $value, $parameters, $validator) {
            $pattern = '/^1[3456789]{1}\d{9}$/';
            $res = preg_match($pattern, $value);
            return $res > 0;
        });
        Validator::replacer('mobile', function ($message, $attribute, $rule, $parameters) {
            return $message;
        });

        //验证身份证号
        Validator::extend('identity', function ($attribute, $value, $parameters, $validator) {
            return $this->checkIdentityCard($value);
        });
        Validator::replacer('identity', function ($message, $attribute, $rule, $parameters) {
            return $message;
        });

        //验证密码长度及强度.三个参数:最小长度,最大长度,密码强度1-4
        Validator::extend('pwdStrength', function ($attribute, $value, $parameters, $validator) {
            return $this->checkPasswordStrength($value, $parameters);
        });
        Validator::replacer('pwdStrength', function ($message, $attribute, $rule, $parameters) {
            return $message;
        });
        //中文名
        Validator::extend('chinese_name', function ($attribute, $value, $parameters, $validator) {
            return \JoyceZ\LaravelLib\Validation\Validator::isChineseName($value);
        });
        Validator::replacer('chinese_name', function ($message, $attribute, $rule, $parameters) {
            return $message;
        });
        //验证是否是非负数、非小数点数字。用于 数字 ID 验证
        Validator::extend('positive_id', function ($attribute, $value, $parameters, $validator) {
            return \JoyceZ\LaravelLib\Validation\Validator::isPositive($value);
        });
        Validator::replacer('positive_id', function ($message, $attribute, $rule, $parameters) {
            return $message;
        });
    }

    /**
     * 验证身份证
     * @param $idCard
     * @return bool
     * @author centphp.com
     * @date 2020/5/1
     */
    public function checkIdentityCard($idCard)
    {
        // 只能是18位
        if (strlen($idCard) != 18) {
            return false;
        }
        // 取出本体码
        $idcard_base = substr($idCard, 0, 17);
        // 取出校验码
        $verify_code = substr($idCard, 17, 1);
        // 加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        // 校验码对应值
        $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        // 根据前17位计算校验码
        $total = 0;
        for ($i = 0; $i < 17; $i++) {
            $total += substr($idcard_base, $i, 1) * $factor[$i];
        }
        // 取模
        $mod = $total % 11;
        // 比较校验码
        if ($verify_code == $verify_code_list[$mod]) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 验证密码
     * @param $password
     * @param $parameters
     * @return bool
     * @author centphp.com
     * @date 2020/5/1
     */
    public function checkPasswordStrength($password, $parameters)
    {
        $pwd_len = strlen($password);
        if ($pwd_len > $parameters[1] || $pwd_len < $parameters[0]) {
            return false;
        }
        //1) 是否包含小写字母
        $pattern = '/[a-z]+/';
        $res = preg_match($pattern, $password);
        //2) 是否包含大写字母
        $pattern = '/[A-Z]+/';
        $res2 = preg_match($pattern, $password);
        //3) 是否包含数字
        $pattern = '/\d+/';
        $res3 = preg_match($pattern, $password);
        //4) 是否包含特殊符号
        $pattern = '/[\!\@\#\$\%\^\&\*\(\)\_\+\-\=\;\:\"\'\|\\\<\>\?\/\.\,\`\~]+/';
        $res4 = preg_match($pattern, $password);

        $sum = $res + $res2 + $res3 + $res4;
        return $sum >= $parameters[2];
    }
}
