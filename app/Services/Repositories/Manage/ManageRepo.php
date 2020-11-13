<?php
declare (strict_types=1);

namespace App\Services\Repositories\Manage;


use App\Events\ManageAction;
use App\Services\Models\Manage\ManageModel;
use App\Services\Repositories\Manage\Interfaces\IManage;
use Illuminate\Support\Facades\Auth;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Helpers\StrHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

/**
 * 管理员
 * Class ManageRepo
 * @package App\Services\Repositories\Manage
 */
class ManageRepo extends BaseRepository implements IManage
{

    public function __construct(ManageModel $model)
    {
        parent::__construct($model);
    }

    /**
     * 管理员登录
     * @param string $username 登录名
     * @param string $password 密码
     * @param string $captcha 验证码
     * @param string $clientIp 客户端ip
     * @return array
     * @throws \Exception
     */
    public function doLogin(string $username, string $password, string $captcha, string $clientIp): array
    {
        $getCaptcha = cache('adminCaptcha');
        if (empty($captcha) || (strtolower($captcha) != strtolower($getCaptcha))) {
            return ResultHelper::returnFormat('验证码错误！', -1);
        }
        if (empty($username)) {
            return ResultHelper::returnFormat('用户名不能为空！', -1);
        }
        if (empty($password)) {
            return ResultHelper::returnFormat('密码不能为空！', -1);
        }
        $loginResult = Auth::guard('admin')->attempt(['username' => $username, 'password' => $password]);
        if ($loginResult) {
            $user = Auth::guard('admin')->user();
            if (intval($user['manage_status']) !== 1) {
                //被禁用用户，直接退出登录
                Auth::guard('admin')->logout();
                return ResultHelper::returnFormat('用户被禁用！', -1);
            }
            // 更新登录信息
            $data['last_login_ip'] = StrHelper::ip2long($clientIp);
            $data['last_login_time'] = time();
            $this->model->where('manage_id', $user->manage_id)->update($data);
            // 监听登录，并记录日志
            event(new ManageAction($user->manage_id, $user->username, request()->url(), '登录', [], $clientIp, request()->userAgent()));
            return ResultHelper::returnFormat('登录成功！', 200);
        } else {

            // 清除验证码
            cache(['adminCaptcha' => null], 60 * 10);

            return ResultHelper::returnFormat('用户名或密码错误！', -1);
        }
    }

    /*
     * 管理员列表
     */
    public function getManagePageLists(array $params): array
    {
        $lists = $this->model->where(function ($query) use ($params) {
            if (isset($params['search_text']) && $params['search_text'] != '') {
                $query->where('username', 'like', '%' . $params['search_text'] . '%');
            }
            if (isset($params['created_time']) && $params['created_time'] != '') {
                $date = explode('至', $params['created_time']);
                $query->where('reg_date', '>=', strtotime(trim($date[0])))->where('reg_date', '<=', strtotime(trim($date[1])));
            }
        })
            ->select(['manage_id', 'username', 'realname', 'manage_avatar', 'is_super', 'reg_date', 'reg_ip', 'last_login_ip', 'last_login_time', 'manage_status', 'updated_at'])
            ->orderBy('reg_date', 'desc')
            ->paginate(isset($params['page_size']) ? $params['page_size'] : config('student.paginate.page_size'));
        return $lists->toArray();
    }

    /**
     * 创建登录用户
     * @param array $params
     * @return bool
     */
    public function doCreateAdmin($request): bool
    {
        $admin = $this->doCreate([
            'username' => $request->username,
            'nickname' => '',
            'realname' => $request->realname,
            'password' => bcrypt($request->password),
            'manage_avatar' => '',
            'is_super' => 0,
            'reg_ip' => StrHelper::ip2long($request->getClientIp()),
            'manage_status' => $request->manage_status ? 1 : 0,
            'last_login_ip' => 0,
            'last_login_time' => 0
        ]);
        if ($admin) {
            $admin->roles()->sync(array_filter(array_unique($request->roles)));
            return true;
        }
        return false;
    }

    /**
     * 根据用户id，修改用户信息
     * @param int $id
     * @param array $params
     * @return bool
     */
    public function doUpdateAdmin(int $id, array $params): bool
    {
        $admin = $this->getByPkId($id);
        if (!$admin) {
            return false;
        }
        $admin->nickname = '';
        $admin->realname = $params['realname'];
        $admin->manage_avatar = '';
        $admin->manage_status = isset($params['manage_status']) ? 1 : 0;
        if ($admin->save()) {
            $admin->roles()->sync(array_filter(array_unique($params['roles'])));
            return true;
        }
        return false;
    }


}
