<?php
declare (strict_types=1);

namespace App\Services\Models\Manage;

use App\Services\Enums\Manage\ManageStatusEnum;
use App\Services\Enums\Manage\ManageSuperEnum;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * 管理员
 *
 * @author joyecZhang <zhangwei762@163.com>
 * Class Manage
 * @package App\Services\Models\Manage
 */
class Manage extends Authenticatable
{
    use Notifiable;

    /**
     * 表名
     * @var string
     */
    protected $table = 'hb_manage';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'manage_id';

    const CREATED_AT = 'reg_date'; //创建时间，注册时间
    const UPDATED_AT = 'updated_at'; //修改时间

    /**
     * 指示是否自动维护时间戳
     * @var bool
     */
    public $timestamps = true;

    /**
     * 模型日期列的存储格式。
     * @var string
     */
    protected $dateFormat = 'U';

    protected $fillable = [
        'manage_id',
        'username',
        'nickname',
        'realname',
        'password',
        'manage_avatar',
        'is_super',
        'remember_token',
        'reg_date',
        'reg_ip',
        'last_login_ip',
        'last_login_time',
        'manage_status',
        'updated_at',
    ];

    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * 注册时间
     * @return false|string
     */
    public function getRegdateTxtAttribute()
    {
        return date('Y-m-d H:i:s', $this->attributes['reg_date']);
    }

    /**
     * 最后登录时间
     * @return false|string
     */
    public function getLastLoginTimeAttribute()
    {
        return date('Y-m-d H:i:s', $this->attributes['last_login_time']);
    }

    /**
     * 注册ip地址
     * @return string
     */
    public function getRegIpAttribute()
    {
        return long2ip($this->attributes['reg_ip']);
    }

    /**
     * 最后登录ip地址
     * @return string
     */
    public function getLastLoginIpAttribute()
    {
        return long2ip($this->attributes['last_login_ip']);
    }

    /**
     * 管理员状态值说明
     * @return mixed|string
     */
    public function getManageStatusTxtAttribute()
    {
        $status = ManageStatusEnum::getMap();
        return isset($status[$this->attributes['manage_status']]) ? $status[$this->attributes['manage_status']] : '';
    }

    /**
     * 管理员状态值说明
     * @return mixed|string
     */
    public function getIsSuperTxtAttribute()
    {
        $super = ManageSuperEnum::getMap();
        return isset($super[$this->attributes['is_super']]) ? $super[$this->attributes['is_super']] : '';
    }

    /**
     * 关联用户下多个角色
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(ManageRole::class,'hb_manage_has_role','manage_id','role_id');
    }

}
