<?php

use Illuminate\Database\Seeder;

class ManageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //添加超级管理员
        $manageId = \Illuminate\Support\Facades\DB::table('hb_manage')->insertGetId([
            'username' => 'admin',
            'nickname' => '超级管理员',
            'realname' => '超级管理员',
            'password' => bcrypt('123456'),
            'manage_avatar' => '',
            'is_super' => 1,
            'reg_date' => time(),
            'reg_ip' => \JoyceZ\LaravelLib\Helpers\StrHelper::ip2long(),
            'last_login_ip' => \JoyceZ\LaravelLib\Helpers\StrHelper::ip2long(),
            'last_login_time' => time(),
            'manage_status' => 1,
            'updated_at' => time()
        ]);

        //添加超级管理员角色
        $roleId = \Illuminate\Support\Facades\DB::table('hb_manage_role')->insertGetId([
            'role_title' => '超级管理员',
            'is_default' => 1,
            'role_desc' => '超级管理员角色，不可操作',
            'created_at' => time(),
            'updated_at' => time()
        ]);

        //绑定超级管理员角色
        \Illuminate\Support\Facades\DB::table('hb_manage_has_role')->insert([
            [
                'role_id' => $roleId,
                'manage_id' => $manageId
            ]
        ]);
    }
}
