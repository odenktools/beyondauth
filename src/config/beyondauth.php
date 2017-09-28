<?php

return [

    'hash' => 'bcrypt',

    'permission_cache' => true,

    'auto_confirm' => true,

    'default_role_name' => 'member',

    'usermodel' => 'Pribumi\BeyondAuth\Models\User',

    'companymodel' => 'Pribumi\BeyondAuth\Models\Company',

    'customermodel' => 'Pribumi\BeyondAuth\Models\Customer',

    'models' => [
        'usergroup' => 'Pribumi\Stoplite\Models\UserGroup',
    ],

    'views' => [
        'login' => 'login',
    ],

    'email' => [
        'address' => 'akusuka@pribumitech.com',
        'title' => '',
        'subject' => '',
    ],
    'routes' => [
        'afterLogout' => '/admin/login',
        'afterLogin' => '/admin/landing',
    ],
    'tables' => [
        'prefix' => '',
        'keys' => [
            'masters' => [
                'periode' => 'id_periode',
                'field_types' => 'id_field_type',
                'domains' => 'id_domain',
                'users_permissions' => 'id_perm',
                'company' => 'id_company',
                'users' => 'id_users',
                'users_activations' => 'id_activation',
                'api_key_users' => 'id_key',
                'users_fields_groups' => 'id_group_field',
                'users_fields' => 'id_custom_fields', //bukan full master
                'users_groups' => 'id',
                'users_fields_value' => 'id_custom_fields',
                'users_menus' => 'id_menu',
            ],

            'pivot' => [
                'users_fields_domains_many' => 'id_domain_field',
                'users_groups_many' => 'id_user_roles',
                'users_fields_many' => 'id_role_field',
                'users_permissions_many' => 'id_user_perm',
                'users_domains_many' => 'id_user_domain',
                'users_activation_many' => 'id_users_activation',
                'company_activation_many' => 'id_activation',
                'api_key_users_many' => 'id_user_key',
                'users_menus_many' => 'id_user_menu', //end
            ],
        ],

        'masters' => [
            'periode' => 'periode',
            'field_types' => 'field_types',
            'company' => 'company',
            'domains' => 'domains',
            'users_permissions' => 'users_permissions',
            'users' => 'users',
            'users_activations' => 'users_activations',
            'api_key_users' => 'api_key_users',
            'users_fields_groups' => 'users_fields_groups',
            'users_fields' => 'users_fields', //bukan full master
            'users_groups' => 'users_groups',
            'users_fields_value' => 'users_fields_value',
            'users_menus' => 'users_menus',
        ],

        'pivot' => [
            'users_fields_domains_many' => 'users_fields_domains_many',
            'users_groups_many' => 'users_groups_many',
            'users_fields_many' => 'users_fields_many',
            'users_permissions_many' => 'users_permissions_many',
            'users_domains_many' => 'users_domains_many',
            'users_menus_many' => 'users_menus_many',
            'users_activation_many' => 'users_activation_many',
            'company_activation_many' => 'company_activation_many',
            'userandrole' => 'users_roles_many', //selalu disimpan dibawah
        ],

    ],
];
