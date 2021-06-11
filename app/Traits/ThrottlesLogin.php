<?php


namespace App\Traits;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\InteractsWithTime;
use Illuminate\Support\Str;

trait ThrottlesLogin
{
    use InteractsWithTime;

    protected $maxAttempts = 5;

    protected $decayMinutes = 30;

    /**
     * 判断是否有多次登录错误
     * @param string $username
     * @param string $ip
     * @return bool
     */
    public function hasTooManyLoginAttempts(string $username, string $ip)
    {
        $cacheKey = $this->throttleKey($username, $ip);
        if ($this->attempts($cacheKey) >= $this->maxAttempts) {
            if (Cache::has($cacheKey . ':timer')) {
                return true;
            }
            $this->clearLoginAttempts($cacheKey);
        }
        return false;
    }

    /**
     * 多少分钟后可再次登录
     * @param string $username
     * @param string $ip
     * @return array
     */
    public function sendLockoutResponse(string $username, string $ip)
    {
        $seconds = $this->availableIn(
            $this->throttleKey($username, $ip)
        );
        return ['seconds' => $seconds,
            'minutes' => ceil($seconds / 60)];
    }

    /**
     * 增加错误次数
     * @param string $username
     * @param string $ip
     */
    public function incrementLoginAttempts(string $username, string $ip)
    {
        $decaySeconds = $this->decayMinutes * 60;
        $cacheKey = $this->throttleKey($username, $ip);
        Cache::add(
            $cacheKey . ':timer', $this->availableAt($decaySeconds), $decaySeconds
        );
        if (Cache::has($cacheKey)) {
            Cache::increment($cacheKey);
        } else {
            Cache::add($cacheKey, 0, $decaySeconds);
        }

    }

    /**
     * 清除缓存
     * @param $key
     */
    public function clearLoginAttempts($key)
    {
        Cache::forget($key);
        Cache::forget($key . ':timer');
    }

    public function availableIn($key)
    {
        return Cache::get($key.':timer') - $this->currentTime();
    }

    /**
     * 组装缓存key
     * @param string $username
     * @param string $ip
     * @return string
     */
    protected function throttleKey(string $username, string $ip)
    {
        return Str::lower($username) . '|' . $ip;
    }


    /**
     * Get the current system time as a UNIX timestamp.
     *
     * @return int
     */
    protected function currentTime()
    {
        return Carbon::now()->getTimestamp();
    }

    /**
     * 获取密码错误次数
     * @param $key
     * @return mixed
     */
    public function attempts($key)
    {
        return Cache::get($key, 0);
    }


    /**
     * 获取剩余次数
     * @param string $username
     * @param string $ip
     * @return int|mixed
     */
    public function retriesLeft(string $username, string $ip)
    {
        $key = $this->throttleKey($username, $ip);
        $attempts = $this->attempts($key);

        return $this->maxAttempts - $attempts;
    }
}
