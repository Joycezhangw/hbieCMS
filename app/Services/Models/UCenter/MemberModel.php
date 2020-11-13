<?php
declare (strict_types=1);

namespace App\Services\Models\UCenter;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * 用户
 * Class MemberModel
 * @package App\Services\Models\UCenter
 */
class MemberModel extends Authenticatable
{
    use Notifiable;

    /**
     * 表名
     * @var string
     */
    protected $table = 'uc_member';

    /**
     * 主键字段
     * @var string
     */
    protected $primaryKey = 'uid';

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
        'uid',
        'username',
        'nickname',
        'realname',
        'password',
        'user_mobile',
        'user_salt',
        'user_email',
        'user_avatar',
        'user_state',
        'is_super',
        'remember_token',
        'reg_date',
        'reg_ip',
        'group_id',
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
        'password', 'remember_token', 'user_salt'
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
        return $this->attributes['last_login_time'] > 0 ? date('Y-m-d H:i:s', $this->attributes['last_login_time']) : '-';
    }

    /**
     * 注册ip地址
     * @return string
     */
    public function getRegIpAttribute()
    {
        return $this->attributes['reg_ip'] > 0 ? long2ip($this->attributes['reg_ip']) : '-';
    }

    /**
     * 最后登录ip地址
     * @return string
     */
    public function getLastLoginIpAttribute()
    {
        return $this->attributes['last_login_ip'] > 0 ? long2ip($this->attributes['last_login_ip']) : '-';
    }


    /**
     * 关联会员组
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function group()
    {
        return $this->hasOne(MemberGroupModel::class);
    }
}
