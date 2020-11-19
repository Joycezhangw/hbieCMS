<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManageModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10001', '概况', 'manage', 'Index', 'index', '0', '1', 'manage.index.index', '1', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10002', '内容', 'manage', 'Article', 'index', '0', '1', 'manage.article.index', '1', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10003', '栏目管理', 'manage', 'Channel', 'index', '10002', '2', 'manage.channel.index', '1', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10004', '创建栏目', 'manage', 'Channel', 'create', '10003', '3', 'manage.channel.create', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10005', '修改栏目', 'manage', 'Channel', 'edit', '10003', '3', 'manage.channel.edit', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10006', '提交栏目', 'manage', 'Channel', 'store', '10003', '3', 'manage.channel.store', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10007', '更新栏目', 'manage', 'Channel', 'update', '10003', '3', 'manage.channel.update', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10008', '删除栏目', 'manage', 'Channel', 'destroy', '10003', '3', 'manage.channel.destroy', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10009', '栏目排序', 'manage', 'Channel', 'modifySort', '10003', '3', 'manage.channel.modifySort', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10010', '栏目列表快捷更新', 'manage', 'Channel', 'modifyFiled', '10003', '3', 'manage.channel.modifyFiled', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10011', '内容管理', 'manage', 'Article', 'index', '10002', '2', 'manage.article.index', '1', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10012', '创建栏目', 'manage', 'Article', 'create', '10011', '3', 'manage.article.create', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10013', '修改栏目', 'manage', 'Article', 'edit', '10011', '3', 'manage.article.edit', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10014', '提交内容', 'manage', 'Article', 'store', '10011', '3', 'manage.article.store', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10015', '更新内容', 'manage', 'Article', 'update', '10011', '3', 'manage.article.update', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10016', '删除内容', 'manage', 'Article', 'destroy', '10011', '3', 'manage.article.destroy', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10017', '内容列表快捷更新', 'manage', 'Article', 'modifyFiled', '10011', '3', 'manage.article.modifyFiled', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10018', '系统设置', 'manage', 'Admin', 'index', '0', '1', 'manage.admin.index', '1', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10019', '权限管理', 'manage', 'Admin', 'index', '10018', '2', '', '1', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10020', '管理员', 'manage', 'Admin', 'index', '10019', '3', 'manage.admin.index', '1', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10021', '创建管理员', 'manage', 'Admin', 'create', '10020', '4', 'manage.admin.create', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10022', '修改管理员', 'manage', 'Admin', 'edit', '10020', '4', 'manage.admin.edit', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10023', '提交管理员', 'manage', 'Admin', 'store', '10020', '4', 'manage.admin.store', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10024', '更新管理员', 'manage', 'Admin', 'update', '10020', '4', 'manage.admin.update', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10025', '更新状态', 'manage', 'Admin', 'modifyFiled', '10020', '4', 'manage.admin.modifyFiled', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10026', '角色管理', 'manage', 'AdminRole', 'index', '10019', '3', 'manage.adminRole.index', '1', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10027', '创建角色', 'manage', 'AdminRole', 'create', '10026', '4', 'manage.adminRole.create', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10028', '修改角色', 'manage', 'AdminRole', 'edit', '10026', '4', 'manage.adminRole.edit', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10029', '提交角色', 'manage', 'AdminRole', 'store', '10026', '4', 'manage.adminRole.store', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10030', '更新角色', 'manage', 'AdminRole', 'update', '10026', '4', 'manage.adminRole.update', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10031', '删除角色', 'manage', 'AdminRole', 'destroy', '10026', '4', 'manage.adminRole.destroy', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10032', '管理员日志', 'manage', 'AdminLog', 'index', '10019', '3', 'manage.adminLog.index', '1', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10033', '删除日志', 'manage', 'AdminLog', 'destroy', '10032', '4', 'manage.adminLog.destroy', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10034', '菜单规则', 'manage', 'AdminRule', 'index', '10019', '3', 'manage.adminRule.index', '1', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10035', '创建菜单', 'manage', 'AdminRule', 'create', '10034', '4', 'manage.adminRule.create', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10036', '修改菜单', 'manage', 'AdminRule', 'edit', '10034', '4', 'manage.adminRule.edit', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10037', '提交菜单', 'manage', 'AdminRule', 'store', '10034', '4', 'manage.adminRule.store', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10038', '更新菜单', 'manage', 'AdminRule', 'update', '10034', '4', 'manage.adminRule.update', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10039', '删除菜单', 'manage', 'AdminRule', 'destroy', '10034', '4', 'manage.adminRule.destroy', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10040', '列表快捷更新', 'manage', 'AdminRule', 'modifyFiled', '10034', '4', 'manage.adminRule.modifyFiled', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10041', '基础设置', 'manage', '', '', '10018', '2', '', '1', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10042', '幻灯片管理', 'manage', 'Slide', 'index', '10041', '3', 'manage.slide.index', '1', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10043', '创建幻灯片', 'manage', 'Slide', 'create', '10042', '4', 'manage.slide.create', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10044', '修改幻灯片', 'manage', 'Slide', 'edit', '10042', '4', 'manage.slide.edit', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10045', '提交幻灯片', 'manage', 'Slide', 'store', '10042', '4', 'manage.slide.store', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10046', '更新幻灯片', 'manage', 'Slide', 'update', '10042', '4', 'manage.slide.update', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10047', '幻灯片排序', 'manage', 'Slide', 'modifySort', '10042', '4', 'manage.slide.modifySort', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10048', '删除幻灯片', 'manage', 'Slide', 'destroy', '10042', '4', 'manage.slide.destroy', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10049', '列表快捷更新', 'manage', 'Slide', 'modifyFiled', '10042', '4', 'manage.slide.modifyFiled', '0', '0', '', '', '1594367111', '1594367111');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10050', '首页金刚区', 'manage', 'MpPages', 'index', '10041', '3', 'manage.mpPages.index', '1', '0', '', '', '1605752258', '1605752258');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10051', '创建页面', 'manage', 'MpPages', 'create', '10050', '4', 'manage.mpPages.create', '0', '0', '', '', '1605752303', '1605752303');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10052', '修改页面', 'manage', 'MpPages', 'edit', '10050', '4', 'manage.mpPages.edit', '0', '0', '', '', '1605752333', '1605752333');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10053', '提交数据', 'manage', 'MpPages', 'store', '10050', '4', 'manage.mpPages.store', '0', '0', '', '', '1605752373', '1605752373');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10054', '更新数据', 'manage', 'MpPages', 'update', '10050', '4', 'manage.mpPages.update', '0', '0', '', '', '1605752402', '1605752402');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10055', '删除数据', 'manage', 'MpPages', 'destroy', '10050', '4', 'manage.mpPages.destroy', '0', '0', '', '', '1605752437', '1605752437');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10056', '更新排序', 'manage', 'MpPages', 'modifySort', '10050', '4', 'manage.mpPages.modifySort', '0', '0', '', '', '1605752470', '1605752470');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10057', '附件管理', 'manage', 'Attachment', 'index', '10018', '2', 'manage.attachment.index', '1', '0', '', '', '1605754788', '1605754788');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10058', '创建专辑', 'manage', 'Attachment', 'store', '10057', '3', 'manage.attachment.store', '0', '0', '', '', '1605754863', '1605754863');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10059', '修改专辑', 'manage', 'Attachment', 'update', '10057', '3', 'manage.attachment.update', '0', '0', '', '', '1605754895', '1605754895');");
        DB::insert("INSERT INTO `hb_manage_module` VALUES ('10060', '删除专辑', 'manage', 'Attachment', 'destroy', '10057', '3', 'manage.attachment.destroy', '0', '0', '', '', '1605754922', '1605754922');");
    }
}
