<?php

use Illuminate\Database\Seeder;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        //添加超级管理员角色
        $group_id = \Illuminate\Support\Facades\DB::table('uc_member_group')->insertGetId([
            'group_title' => '超级管理员',
            'group_type' => 'system',
            'is_system' => 1,
            'is_default' => 1,
            'group_remark' => '超级管理员角色，不可操作',
            'created_at' => time(),
            'updated_at' => time()
        ]);

        //添加超级管理员角色
        \Illuminate\Support\Facades\DB::table('uc_member_group')->insertGetId([
            'group_title' => '普通会员',
            'group_type' => 'member',
            'is_system' => 0,
            'is_default' => 1,
            'group_remark' => '默认普通会员组，不可操作',
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $salt = \Illuminate\Support\Str::random(6);
        //添加超级管理员
        $manageId = \Illuminate\Support\Facades\DB::table('uc_member')->insertGetId([
            'username' => 'admin',
            'nickname' => '超级管理员',
            'realname' => '超级管理员',
            'password' => bcrypt('123456' . $salt),
            'user_mobile' => '',
            'user_salt' => $salt,
            'user_email' => '',
            'user_avatar' => '',
            'user_state' => 1,
            'user_type' => 'system',
            'is_super' => 1,
            'reg_date' => time(),
            'group_id' => $group_id,// 10001,
            'reg_ip' => \JoyceZ\LaravelLib\Helpers\StrHelper::ip2long(),
            'last_login_ip' => \JoyceZ\LaravelLib\Helpers\StrHelper::ip2long(),
            'last_login_time' => time(),
            'updated_at' => time()
        ]);
    }
}
