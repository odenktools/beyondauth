<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BeyondAuthSeeder extends Seeder
{
    public function run()
    {
        $prefix                        = Config::get('beyondauth.tables.prefix', '');
        $tbl_periode                   = Config::get('beyondauth.tables.masters.periode', '');
        $tbl_field_types               = Config::get('beyondauth.tables.masters.field_types', '');
        $tbl_domains                   = Config::get('beyondauth.tables.masters.domains', '');
        $tbl_users_menus               = Config::get('beyondauth.tables.masters.users_menus', '');
        $tbl_userpermission            = Config::get('beyondauth.tables.masters.users_permissions', '');
        $tbl_user                      = Config::get('beyondauth.tables.masters.users', '');
        $tbl_company                   = Config::get('beyondauth.tables.masters.company', '');
        $tbl_users_fields_groups       = Config::get('beyondauth.tables.masters.users_fields_groups', '');
        $tbl_users_fields              = Config::get('beyondauth.tables.masters.users_fields', '');
        $tbl_users_fields_domains_many = Config::get('beyondauth.tables.pivot.users_fields_domains_many', '');
        $tbl_users_groups              = Config::get('beyondauth.tables.masters.users_groups', '');
        $tbl_users_groups_many         = Config::get('beyondauth.tables.pivot.users_groups_many', '');
        $tbl_users_domains_many        = Config::get('beyondauth.tables.pivot.users_domains_many', '');
        $tbl_users_fields_many         = Config::get('beyondauth.tables.pivot.users_fields_many', '');
        $tbl_users_permissions_many    = Config::get('beyondauth.tables.pivot.users_permissions_many', '');
        $tbl_users_menus_many          = Config::get('beyondauth.tables.pivot.users_menus_many', '');
        $tbl_users_fields_value        = Config::get('beyondauth.tables.masters.users_fields_value', '');
        $tbl_api_key_users             = Config::get('beyondauth.tables.masters.api_key_users', '');

        $periode_1 = DB::table($prefix . $tbl_periode)->insertGetId([
            'code_periode' => 'D',
            'nama_periode' => 'Days',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
            'deleted_at'   => null,
        ]);

        DB::table($prefix . $tbl_periode)->insertGetId([
            'code_periode' => 'W',
            'nama_periode' => 'Weeks',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
            'deleted_at'   => null,
        ]);

        $periode_3 = DB::table($prefix . $tbl_periode)->insertGetId([
            'code_periode' => 'M',
            'nama_periode' => 'Months',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
            'deleted_at'   => null,
        ]);

        DB::table($prefix . $tbl_periode)->insertGetId([
            'code_periode' => 'Y',
            'nama_periode' => 'Years',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
            'deleted_at'   => null,
        ]);

        DB::table($prefix . $tbl_periode)->insertGetId([
            'code_periode' => 'SS',
            'nama_periode' => 'Seconds',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
            'deleted_at'   => null,
        ]);

        DB::table($prefix . $tbl_periode)->insertGetId([
            'code_periode' => 'MN',
            'nama_periode' => 'Minutes',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
            'deleted_at'   => null,
        ]);

        DB::table($prefix . $tbl_field_types)->insertGetId([
            'field_name'        => 'String',
            'code_field_types'  => 'string',
            'field_description' => 'String Value(Max length is 32 chars)',
            'field_size'        => '32',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_field_types)->insertGetId([
            'field_name'        => 'Text',
            'code_field_types'  => 'text',
            'field_description' => 'Long String Value(Max length is 2048 chars)',
            'field_size'        => '2048',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_field_types)->insertGetId([
            'field_name'        => 'Number',
            'code_field_types'  => 'number',
            'field_description' => 'Free style number',
            'field_size'        => '10',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_field_types)->insertGetId([
            'field_name'        => 'SingleSelectList',
            'code_field_types'  => 'singleselectlist',
            'field_description' => 'Single select from list of values',
            'field_size'        => '0',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_field_types)->insertGetId([
            'field_name'        => 'MultiSelectList',
            'code_field_types'  => 'multiselectlist',
            'field_description' => 'Multiple select from list of values',
            'field_size'        => '0',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_field_types)->insertGetId([
            'field_name'        => 'Checkbox',
            'code_field_types'  => 'checkbox',
            'field_description' => '',
            'field_size'        => '0',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_field_types)->insertGetId([
            'field_name'        => 'RadioBoxGroup',
            'code_field_types'  => 'radioboxgroup',
            'field_description' => '',
            'field_size'        => '0',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_field_types)->insertGetId([
            'field_name'        => 'Date',
            'code_field_types'  => 'date',
            'field_description' => 'Date',
            'field_size'        => '0',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_field_types)->insertGetId([
            'field_name'        => 'Time',
            'code_field_types'  => 'time',
            'field_description' => 'Time',
            'field_size'        => '0',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_field_types)->insertGetId([
            'field_name'        => 'DateTime',
            'code_field_types'  => 'datetime',
            'field_description' => 'DateTime',
            'field_size'        => '0',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        $domains_1 = DB::table($prefix . $tbl_domains)->insertGetId([
            'domain_name'      => 'http://odenktools.com',
            'code_domain_name' => 'odenktools.com',
            'is_active'        => '1',
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
            'deleted_at'       => null,
        ]);

        DB::table($prefix . $tbl_domains)->insertGetId([
            'domain_name'      => 'http://ngakost.net',
            'code_domain_name' => 'ngakost.net',
            'is_active'        => '1',
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
            'deleted_at'       => null,
        ]);

        DB::table($prefix . $tbl_domains)->insertGetId([
            'domain_name'      => 'http://solusisehat.com',
            'code_domain_name' => 'solusisehat.com',
            'is_active'        => '0',
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
            'deleted_at'       => null,
        ]);

        DB::table($prefix . $tbl_domains)->insertGetId([
            'domain_name'      => 'http://teknikmesinindo.com',
            'code_domain_name' => 'teknikmesinindo.com',
            'is_active'        => '0',
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
            'deleted_at'       => null,
        ]);

        $domains_5 = DB::table($prefix . $tbl_domains)->insertGetId([
            'domain_name'      => 'http://local.pribumicms.net',
            'code_domain_name' => 'local.pribumicms.net',
            'is_active'        => '1',
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
            'deleted_at'       => null,
        ]);

        /* ====================== #START USER MENU ============================= */
        $users_menus_1 = DB::table($prefix . $tbl_users_menus)->insertGetId([
            'parent_menu'   => '0',
            'menu_title'    => 'Root',
            'menu_name'     => '',
            'backend_route' => null,
            'image'         => null,
            'is_active'     => '1',
            'menu_order'    => '0',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ]);

        $users_menus_2 = DB::table($prefix . $tbl_users_menus)->insertGetId([
            'parent_menu'   => '1',
            'menu_title'    => 'Dashboard',
            'menu_name'     => '',
            'backend_route' => null,
            'image'         => null,
            'is_active'     => '1',
            'menu_order'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ]);

        $users_menus_3 = DB::table($prefix . $tbl_users_menus)->insertGetId([
            'parent_menu'   => '1',
            'menu_title'    => 'Route Editor',
            'menu_name'     => '',
            'backend_route' => null,
            'image'         => null,
            'is_active'     => '1',
            'menu_order'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ]);

        $users_menus_4 = DB::table($prefix . $tbl_users_menus)->insertGetId([
            'parent_menu'   => '1',
            'menu_title'    => 'Domain',
            'menu_name'     => '',
            'backend_route' => 'domains',
            'image'         => null,
            'is_active'     => '1',
            'menu_order'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ]);

        $users_menus_5 = DB::table($prefix . $tbl_users_menus)->insertGetId([
            'parent_menu'   => '1',
            'menu_title'    => 'User',
            'menu_name'     => '',
            'backend_route' => null,
            'image'         => null,
            'is_active'     => '0',
            'menu_order'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ]);

        $users_menus_6 = DB::table($prefix . $tbl_users_menus)->insertGetId([
            'parent_menu'   => '5',
            'menu_title'    => 'User Group',
            'menu_name'     => '',
            'backend_route' => 'usergroup',
            'image'         => null,
            'is_active'     => '1',
            'menu_order'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ]);

        $users_menus_7 = DB::table($prefix . $tbl_users_menus)->insertGetId([
            'parent_menu'   => '1',
            'menu_title'    => 'User Field',
            'menu_name'     => '',
            'backend_route' => null,
            'image'         => null,
            'is_active'     => '1',
            'menu_order'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ]);

        $users_menus_8 = DB::table($prefix . $tbl_users_menus)->insertGetId([
            'parent_menu'   => '7',
            'menu_title'    => 'Field',
            'menu_name'     => '',
            'backend_route' => 'userfield',
            'image'         => null,
            'is_active'     => '1',
            'menu_order'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ]);

        $users_menus_9 = DB::table($prefix . $tbl_users_menus)->insertGetId([
            'parent_menu'   => '7',
            'menu_title'    => 'Field Group',
            'menu_name'     => '',
            'backend_route' => 'userfield_group',
            'image'         => null,
            'is_active'     => '1',
            'menu_order'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ]);

        $users_menus_10 = DB::table($prefix . $tbl_users_menus)->insertGetId([
            'parent_menu'   => '1',
            'menu_title'    => 'Lokalisasi',
            'menu_name'     => '',
            'backend_route' => null,
            'image'         => null,
            'is_active'     => '1',
            'menu_order'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ]);

        $users_menus_11 = DB::table($prefix . $tbl_users_menus)->insertGetId([
            'parent_menu'   => '10',
            'menu_title'    => 'Bahasa',
            'menu_name'     => '',
            'backend_route' => null,
            'image'         => null,
            'is_active'     => '1',
            'menu_order'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ]);

        $users_menus_12 = DB::table($prefix . $tbl_users_menus)->insertGetId([
            'parent_menu'   => '10',
            'menu_title'    => 'Return',
            'menu_name'     => '',
            'backend_route' => null,
            'image'         => null,
            'is_active'     => '1',
            'menu_order'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ]);

        $users_menus_13 = DB::table($prefix . $tbl_users_menus)->insertGetId([
            'parent_menu'   => '12',
            'menu_title'    => 'Return Status',
            'menu_name'     => '',
            'backend_route' => null,
            'image'         => null,
            'is_active'     => '1',
            'menu_order'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ]);

        $users_menus_14 = DB::table($prefix . $tbl_users_menus)->insertGetId([
            'parent_menu'   => '12',
            'menu_title'    => 'Return Action',
            'menu_name'     => '',
            'backend_route' => null,
            'image'         => null,
            'is_active'     => '1',
            'menu_order'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => null,
        ]);
        /* ====================== #END USER MENU ============================= */

        $user_perm_1 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'user.create',
            'readable_name'   => 'Create User',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_2 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'user.edit',
            'readable_name'   => 'Edit User',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_3 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'user.delete',
            'readable_name'   => 'Delete User',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_4 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'user.view',
            'readable_name'   => 'View User',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_5 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'usergroup.create',
            'readable_name'   => 'Create Usergroup',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_6 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'usergroup.edit',
            'readable_name'   => 'Edit Usergroup',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_7 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'usergroup.delete',
            'readable_name'   => 'Delete Usergroup',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_8 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'usergroup.view',
            'readable_name'   => 'View Usergroup',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_9 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'userfield_group.create',
            'readable_name'   => 'Create Userfield Group',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_10 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'userfield_group.edit',
            'readable_name'   => 'Edit Userfield Group',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_11 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'userfield_group.delete',
            'readable_name'   => 'Delete Userfield Group',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_12 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'userfield_group.view',
            'readable_name'   => 'View Userfield Group',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_13 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'domains.create',
            'readable_name'   => 'Create Domains',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_14 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'domains.edit',
            'readable_name'   => 'Edit Domains',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_15 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'domains.delete',
            'readable_name'   => 'Delete Domains',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);

        $user_perm_16 = DB::table($prefix . $tbl_userpermission)->insertGetId([
            'name_permission' => 'domains.view',
            'readable_name'   => 'View Domains',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
            'deleted_at'      => null,
        ]);
        //===

        $_passwd = Hash::make('H3lloWorld!', ['cost' => 10]);

        $user_1 = DB::table($prefix . $tbl_user)->insertGetId([
            'username'       => 'admin',
            'email'          => 'admin@pribumitech.com',
            'password'       => $_passwd,
            'salt'           => '',
            'is_builtin'     => '1',
            'is_active'      => '1',
            'verified'       => '1',
            'expire_date'    => null,
            'time_zone'      => null,
            'last_login'     => null,
            'remember_token' => null,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
            'deleted_at'     => null,
        ]);

        $user_2 = DB::table($prefix . $tbl_user)->insertGetId([
            'username'       => 'member',
            'email'          => 'member@pribumitech.com',
            'password'       => $_passwd,
            'salt'           => '',
            'is_builtin'     => '1',
            'is_active'      => '1',
            'verified'       => '1',
            'expire_date'    => '2016-05-19 10:30:12',
            'time_zone'      => null,
            'last_login'     => null,
            'remember_token' => null,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
            'deleted_at'     => null,
        ]);

        $user_3 = DB::table($prefix . $tbl_user)->insertGetId([
            'username'       => 'moeloet',
            'email'          => 'moeloet@pribumitech.com',
            'password'       => $_passwd,
            'salt'           => '',
            'is_builtin'     => '1',
            'is_active'      => '1',
            'verified'       => '1',
            'expire_date'    => null,
            'time_zone'      => null,
            'last_login'     => null,
            'remember_token' => null,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
            'deleted_at'     => null,
        ]);

        DB::table($prefix . $tbl_user)->insertGetId([
            'username'       => 'support',
            'email'          => 'support@pribumitech.com',
            'password'       => $_passwd,
            'salt'           => '',
            'is_builtin'     => '1',
            'is_active'      => '1',
            'verified'       => '1',
            'expire_date'    => null,
            'time_zone'      => null,
            'last_login'     => null,
            'remember_token' => null,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
            'deleted_at'     => null,
        ]);

        $user_5 = DB::table($prefix . $tbl_user)->insertGetId([
            'username'       => 'baduser',
            'email'          => 'baduser@pribumitech.com',
            'password'       => $_passwd,
            'salt'           => '',
            'is_builtin'     => '0',
            'is_active'      => '1',
            'verified'       => '1',
            'expire_date'    => null,
            'time_zone'      => null,
            'last_login'     => null,
            'remember_token' => null,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
            'deleted_at'     => null,
        ]);

        $company_1 = DB::table($prefix . $tbl_company)->insertGetId([
            'name'           => 'pribumitech',
            'email'          => 'pribumitech@gmail.com',
            'password'       => $_passwd,
            'salt'           => '',
            'is_active'      => '1',
            'verified'       => '1',
            'last_login'     => null,
            'remember_token' => null,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
            'deleted_at'     => null,
        ]);

        DB::table($prefix . $tbl_api_key_users)->insertGetId([
            'company_id' => $company_1,
            'apikey'     => '3544a3410c2b88ac4d0e',
            'secretkey'  => 'a02d6be4cacb55388f8e3758db3a06fabd3a460287b08b3e816ab4195d1568a2',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_fields_groups)->insertGetId([
            'group_name'        => 'Personal',
            'group_description' => 'Personal group',
            'group_order'       => '1',
            'is_active'         => '1',
            'admin_use_only'    => '0',
            'is_builtin'        => '1',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_users_fields_groups)->insertGetId([
            'group_name'        => 'Payment',
            'group_description' => 'Payment',
            'group_order'       => '2',
            'is_active'         => '1',
            'admin_use_only'    => '0',
            'is_builtin'        => '1',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_users_fields_groups)->insertGetId([
            'group_name'        => 'Geo Information',
            'group_description' => 'Geo Information',
            'group_order'       => '3',
            'is_active'         => '1',
            'admin_use_only'    => '0',
            'is_builtin'        => '1',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        $users_fields_1 = DB::table($prefix . $tbl_users_fields)->insertGetId([
            'field_type_id'     => '1',
            'group_field_id'    => '1',
            'field_name'        => 'passport_number',
            'field_label'       => 'Passport Number',
            'field_comment'     => 'Passport Number',
            'possible_values'   => null,
            'text_select_value' => null,
            'is_mandatory'      => '0',
            'field_order'       => '3',
            'sort_values'       => '1',
            'is_active'         => '0',
            'show_in_signup'    => '0',
            'admin_use_only'    => '0',
            'is_encrypted'      => '0',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        $users_fields_2 = DB::table($prefix . $tbl_users_fields)->insertGetId([
            'field_type_id'     => '2',
            'group_field_id'    => '1',
            'field_name'        => 'bio_data',
            'field_label'       => 'Bio',
            'field_comment'     => 'Tell us little bit about yourself',
            'possible_values'   => null,
            'text_select_value' => null,
            'is_mandatory'      => '0',
            'field_order'       => '2',
            'sort_values'       => '1',
            'is_active'         => '1',
            'show_in_signup'    => '1',
            'admin_use_only'    => '0',
            'is_encrypted'      => '0',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_users_fields)->insertGetId([
            'field_type_id'     => '1',
            'group_field_id'    => '1',
            'field_name'        => 'first_name',
            'field_label'       => 'First Name',
            'field_comment'     => 'Your First Name',
            'possible_values'   => null,
            'text_select_value' => null,
            'is_mandatory'      => '1',
            'field_order'       => '1',
            'sort_values'       => '1',
            'is_active'         => '1',
            'show_in_signup'    => '1',
            'admin_use_only'    => '0',
            'is_encrypted'      => '0',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_users_fields)->insertGetId([
            'field_type_id'     => '1',
            'group_field_id'    => '3',
            'field_name'        => 'geo_location',
            'field_label'       => 'Geo Location',
            'field_comment'     => 'Your Geo Location',
            'possible_values'   => null,
            'text_select_value' => null,
            'is_mandatory'      => '0',
            'field_order'       => '4',
            'sort_values'       => '1',
            'is_active'         => '1',
            'show_in_signup'    => '1',
            'admin_use_only'    => '0',
            'is_encrypted'      => '0',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_users_fields)->insertGetId([
            'field_type_id'     => '4',
            'group_field_id'    => '1',
            'field_name'        => 'gender',
            'field_label'       => 'Gender',
            'field_comment'     => 'Gender',
            'possible_values'   => 'male;female',
            'text_select_value' => null,
            'is_mandatory'      => '0',
            'field_order'       => '5',
            'sort_values'       => '1',
            'is_active'         => '0',
            'show_in_signup'    => '0',
            'admin_use_only'    => '0',
            'is_encrypted'      => '0',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_users_fields)->insertGetId([
            'field_type_id'     => '1',
            'group_field_id'    => '1',
            'field_name'        => 'phone_number',
            'field_label'       => 'Mobile Phone Number',
            'field_comment'     => 'Your phone number',
            'possible_values'   => null,
            'text_select_value' => null,
            'is_mandatory'      => '1',
            'field_order'       => '6',
            'sort_values'       => '1',
            'is_active'         => '1',
            'show_in_signup'    => '1',
            'admin_use_only'    => '0',
            'is_encrypted'      => '0',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_users_fields)->insertGetId([
            'field_type_id'     => '1',
            'group_field_id'    => '1',
            'field_name'        => 'company',
            'field_label'       => 'Company Name',
            'field_comment'     => 'Your company name',
            'possible_values'   => null,
            'text_select_value' => null,
            'is_mandatory'      => '0',
            'field_order'       => '7',
            'sort_values'       => '1',
            'is_active'         => '1',
            'show_in_signup'    => '1',
            'admin_use_only'    => '0',
            'is_encrypted'      => '0',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_users_fields_value)->insertGetId([
            'user_id'          => $user_1,
            'custom_fields_id' => $users_fields_1,
            'field_value'      => 'B0214345',
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_fields_domains_many)->insertGetId([
            'domain_id'    => $domains_1,
            'userfield_id' => $users_fields_1,
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        $users_groups_1 = DB::table($prefix . $tbl_users_groups)->insertGetId([
            'named'             => 'Super Admin',
            'coded'             => 'superadmin',
            'named_description' => 'Super Admin',
            'is_active'         => '1',
            'is_purchaseable'   => '0',
            'price'             => '0.00',
            'time_left'         => '0',
            'quantity'          => '1',
            'period'            => '1',
            'is_builtin'        => '1',
            'backcolor'         => '00c12e',
            'forecolor'         => 'ffffff',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        $users_groups_2 = DB::table($prefix . $tbl_users_groups)->insertGetId([
            'named'             => 'Admin',
            'coded'             => 'admin',
            'named_description' => 'Power Of Admin',
            'is_active'         => '1',
            'is_purchaseable'   => '0',
            'price'             => '0.00',
            'time_left'         => '0',
            'quantity'          => '1',
            'period'            => $periode_1,
            'is_builtin'        => '1',
            'backcolor'         => 'cc6633',
            'forecolor'         => 'ffffff',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        $users_groups_3 = DB::table($prefix . $tbl_users_groups)->insertGetId([
            'named'             => 'Owner',
            'coded'             => 'owner',
            'named_description' => 'Owner Of Website',
            'is_active'         => '1',
            'is_purchaseable'   => '0',
            'price'             => '0.00',
            'time_left'         => '0',
            'quantity'          => '1',
            'period'            => $periode_1,
            'is_builtin'        => '1',
            'backcolor'         => '99c12e',
            'forecolor'         => 'ffffff',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        $users_groups_4 = DB::table($prefix . $tbl_users_groups)->insertGetId([
            'named'             => 'Member',
            'coded'             => 'member',
            'named_description' => 'Member Of Website',
            'is_active'         => '1',
            'is_purchaseable'   => '1',
            'price'             => '100000.00',
            'time_left'         => '1',
            'quantity'          => '50',
            'period'            => $periode_3,
            'is_builtin'        => '1',
            'backcolor'         => '3aa0df',
            'forecolor'         => 'ffffff',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        $users_groups_5 = DB::table($prefix . $tbl_users_groups)->insertGetId([
            'named'             => 'Banned',
            'coded'             => 'banned',
            'named_description' => 'All Banned User',
            'is_active'         => '0',
            'is_purchaseable'   => '0',
            'price'             => '00',
            'time_left'         => '0',
            'quantity'          => '0',
            'period'            => $periode_1,
            'is_builtin'        => '1',
            'backcolor'         => 'eb6413',
            'forecolor'         => 'ffffff',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'deleted_at'        => null,
        ]);

        DB::table($prefix . $tbl_users_groups_many)->insertGetId([
            'user_id'    => $user_1,
            'group_id'   => $users_groups_1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_groups_many)->insertGetId([
            'user_id'    => $user_2,
            'group_id'   => $users_groups_4,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_groups_many)->insertGetId([
            'user_id'    => $user_3,
            'group_id'   => $users_groups_3,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_groups_many)->insertGetId([
            'user_id'    => $user_5,
            'group_id'   => $users_groups_5,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_domains_many)->insertGetId([
            'user_id'    => $user_1,
            'domain_id'  => $domains_5,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_domains_many)->insertGetId([
            'user_id'    => $user_2,
            'domain_id'  => $domains_5,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_fields_many)->insertGetId([
            'role_id'      => $users_groups_1,
            'userfield_id' => $users_fields_1,
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_fields_many)->insertGetId([
            'role_id'      => $users_groups_2,
            'userfield_id' => $users_fields_2,
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        // ------ TABLE `users_menus_many` 1 ------ //

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_3,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_4,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_5,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_6,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_7,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_8,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_9,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_10,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_11,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_12,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_13,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_14,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_15,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_1,
            'perm_id'    => $user_perm_16,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        // ------ TABLE `users_menus_many` 2 ------ //

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_2,
            'perm_id'    => $user_perm_1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_2,
            'perm_id'    => $user_perm_4,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_2,
            'perm_id'    => $user_perm_5,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_2,
            'perm_id'    => $user_perm_8,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_2,
            'perm_id'    => $user_perm_9,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_2,
            'perm_id'    => $user_perm_12,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_2,
            'perm_id'    => $user_perm_13,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_2,
            'perm_id'    => $user_perm_16,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        // ==

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_3,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_4,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_5,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_6,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_7,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_8,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_9,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_10,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_11,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_12,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_13,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_14,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_15,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_3,
            'perm_id'    => $user_perm_16,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        //==

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_4,
            'perm_id'    => $user_perm_4,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_4,
            'perm_id'    => $user_perm_8,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_4,
            'perm_id'    => $user_perm_12,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_permissions_many)->insertGetId([
            'role_id'    => $users_groups_4,
            'perm_id'    => $user_perm_16,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        //==

        /* ====================== #START `USER MENU MANY` ============================= */
        DB::table($prefix . $tbl_users_menus_many)->insertGetId([
            'group_id'   => $users_groups_1,
            'menu_id'    => $users_menus_1,
            'is_check'   => 'checked',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_menus_many)->insertGetId([
            'group_id'   => $users_groups_1,
            'menu_id'    => $users_menus_2,
            'is_check'   => 'checked',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_menus_many)->insertGetId([
            'group_id'   => $users_groups_1,
            'menu_id'    => $users_menus_3,
            'is_check'   => 'checked',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_menus_many)->insertGetId([
            'group_id'   => $users_groups_1,
            'menu_id'    => $users_menus_4,
            'is_check'   => 'checked',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_menus_many)->insertGetId([
            'group_id'   => $users_groups_1,
            'menu_id'    => $users_menus_5,
            'is_check'   => 'checked',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_menus_many)->insertGetId([
            'group_id'   => $users_groups_1,
            'menu_id'    => $users_menus_6,
            'is_check'   => 'checked',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_menus_many)->insertGetId([
            'group_id'   => $users_groups_1,
            'menu_id'    => $users_menus_7,
            'is_check'   => 'checked',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_menus_many)->insertGetId([
            'group_id'   => $users_groups_1,
            'menu_id'    => $users_menus_8,
            'is_check'   => 'checked',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_menus_many)->insertGetId([
            'group_id'   => $users_groups_1,
            'menu_id'    => $users_menus_9,
            'is_check'   => 'checked',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_menus_many)->insertGetId([
            'group_id'   => $users_groups_1,
            'menu_id'    => $users_menus_10,
            'is_check'   => 'checked',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_menus_many)->insertGetId([
            'group_id'   => $users_groups_1,
            'menu_id'    => $users_menus_11,
            'is_check'   => 'checked',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_menus_many)->insertGetId([
            'group_id'   => $users_groups_1,
            'menu_id'    => $users_menus_12,
            'is_check'   => 'checked',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table($prefix . $tbl_users_menus_many)->insertGetId([
            'group_id'   => $users_groups_1,
            'menu_id'    => $users_menus_13,
            'is_check'   => 'checked',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table($prefix . $tbl_users_menus_many)->insertGetId([
            'group_id'   => $users_groups_1,
            'menu_id'    => $users_menus_14,
            'is_check'   => 'checked',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        /* ====================== #END `USER MENU MANY` ============================= */

        $this->command->info('BeyondAuth tables are seeded!');
    }
}
