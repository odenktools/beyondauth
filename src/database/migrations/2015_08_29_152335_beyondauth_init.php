<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Class BeyondAuth Migration
 *
 * @package Pribumi\BeyondAuth
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 * @link       http://pribumitech.com
 */
class BeyondAuthInit extends Migration
{
    public $prefix                  = null;
    public $periode                 = array('key' => '', 'table' => '');
    public $field_types             = array('key' => '', 'table' => '');
    public $users_menus             = array('key' => '', 'table' => '');
    public $users_permissions       = array('key' => '', 'table' => '');
    public $users                   = array('key' => '', 'table' => '');
    public $company                 = array('key' => '', 'table' => '');
    public $users_fields_groups     = array('key' => '', 'table' => '');
    public $users_fields            = array('key' => '', 'table' => '');
    public $users_groups            = array('key' => '', 'table' => '');
    public $users_groups_many       = array('key' => '', 'table' => '');
    public $users_fields_many       = array('key' => '', 'table' => '');
    public $users_fields_value      = array('key' => '', 'table' => '');
    public $users_permissions_many  = array('key' => '', 'table' => '');
    public $users_menus_many        = array('key' => '', 'table' => '');
    public $activation_users        = array('key' => '', 'table' => '');
    public $users_activation_many   = array('key' => '', 'table' => '');
    public $company_activation_many = array('key' => '', 'table' => '');
    public $api_key_users           = array('key' => '', 'table' => '');

    /**
     *
     */
    public function __construct()
    {
        $this->prefix = Config::get('beyondauth.tables.prefix', '');

        //Master Table
        $this->periode['table'] = Config::get('beyondauth.tables.masters.periode', '');
        $this->periode['key']   = Config::get('beyondauth.tables.keys.masters.periode', '');

        //Master Table
        $this->activation_users['table'] = Config::get('beyondauth.tables.masters.users_activations', '');
        $this->activation_users['key']   = Config::get('beyondauth.tables.keys.masters.users_activations', '');

        $this->users_activation_many['table'] = Config::get('beyondauth.tables.pivot.users_activation_many', '');
        $this->users_activation_many['key']   = Config::get('beyondauth.tables.keys.pivot.users_activation_many', '');

        $this->company_activation_many['table'] = Config::get('beyondauth.tables.pivot.company_activation_many', '');
        $this->company_activation_many['key']   = Config::get('beyondauth.tables.keys.pivot.company_activation_many', '');

        //Master Table
        $this->api_key_users['table'] = Config::get('beyondauth.tables.masters.api_key_users', '');
        $this->api_key_users['key']   = Config::get('beyondauth.tables.keys.masters.api_key_users', '');

        //Master
        $this->field_types['table'] = Config::get('beyondauth.tables.masters.field_types', '');
        $this->field_types['key']   = Config::get('beyondauth.tables.keys.masters.field_types', '');

        //Master Table
        $this->users_menus['table'] = Config::get('beyondauth.tables.masters.users_menus', '');
        $this->users_menus['key']   = Config::get('beyondauth.tables.keys.masters.users_menus', '');

        //Master Table
        $this->users_permissions['table'] = Config::get('beyondauth.tables.masters.users_permissions', '');
        $this->users_permissions['key']   = Config::get('beyondauth.tables.keys.masters.users_permissions', '');

        //Master Table
        $this->users['table'] = Config::get('beyondauth.tables.masters.users', '');
        $this->users['key']   = Config::get('beyondauth.tables.keys.masters.users', '');

        //Master Table
        $this->company['table'] = Config::get('beyondauth.tables.masters.company', '');
        $this->company['key']   = Config::get('beyondauth.tables.keys.masters.company', '');

        //Master Table
        $this->users_fields_groups['table'] = Config::get('beyondauth.tables.masters.users_fields_groups', '');
        $this->users_fields_groups['key']   = Config::get('beyondauth.tables.keys.masters.users_fields_groups', '');

        //Master Table
        $this->users_fields['table'] = Config::get('beyondauth.tables.masters.users_fields', '');
        $this->users_fields['key']   = Config::get('beyondauth.tables.keys.masters.users_fields', '');

        //Master Table
        $this->users_groups['table'] = Config::get('beyondauth.tables.masters.users_groups', '');
        $this->users_groups['key']   = Config::get('beyondauth.tables.keys.masters.users_groups', '');

        //Pivot Table
        $this->users_groups_many['table'] = Config::get('beyondauth.tables.pivot.users_groups_many', '');
        $this->users_groups_many['key']   = Config::get('beyondauth.tables.keys.pivot.users_groups_many', '');

        //Pivot Table
        $this->users_fields_many['table'] = Config::get('beyondauth.tables.pivot.users_fields_many', '');
        $this->users_fields_many['key']   = Config::get('beyondauth.tables.keys.pivot.users_fields_many', '');

        //Master Table
        $this->users_fields_value['table'] = Config::get('beyondauth.tables.masters.users_fields_value', '');
        $this->users_fields_value['key']   = Config::get('beyondauth.tables.keys.masters.users_fields_value', '');

        //Pivot Table
        $this->users_permissions_many['table'] = Config::get('beyondauth.tables.pivot.users_permissions_many', '');
        $this->users_permissions_many['key']   = Config::get('beyondauth.tables.keys.pivot.users_permissions_many', '');

        //Pivot Table
        $this->users_menus_many['table'] = Config::get('beyondauth.tables.pivot.users_menus_many', '');
        $this->users_menus_many['key']   = Config::get('beyondauth.tables.keys.pivot.users_menus_many', '');

    }

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        $prefix = $this->prefix;

        //Master Table
        Schema::create($prefix . $this->periode['table'], function ($table) {
            $table->engine = 'InnoDB';
            $table->increments($this->periode['key']);
            $table->string('code_periode', 100)->unique();
            $table->string('nama_periode', 100)->index();
            $table->timestamps();
            $table->softDeletes();

        });

        //Master Table
        Schema::create($prefix . $this->activation_users['table'], function ($table) {
            $table->engine = 'InnoDB';
            $table->increments($this->activation_users['key']);
            $table->string('activation_code', 100)->index();
            $table->timestamps();
        });

        //Master Table
        Schema::create($prefix . $this->field_types['table'], function ($table) {
            $table->engine = 'InnoDB';
            $table->increments($this->field_types['key']);
            $table->string('field_name', 128)->index()->unique();
            $table->string('code_field_types', 128)->unique();
            $table->text('field_description', 128)->nullable();
            $table->integer('field_size')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        //Master Table
        Schema::create($prefix . $this->users_menus['table'], function ($table) {
            $table->engine = 'InnoDB';
            $table->increments($this->users_menus['key']);
            $table->integer('parent_menu');
            $table->string('menu_title', 50)->nullable();
            $table->string('menu_name', 50)->nullable();
            $table->string('backend_route', 128)->nullable();
            $table->string('image', 255)->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('menu_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        //Master Table
        Schema::create($prefix . $this->users_permissions['table'], function ($table) {
            $table->engine = 'InnoDB';
            $table->increments($this->users_permissions['key']);
            $table->string('name_permission', 50)->unique();
            $table->string('readable_name', 50)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        //Master Table
        Schema::create($prefix . $this->users['table'], function ($table) {
            $table->engine = 'InnoDB';
            $table->increments($this->users['key']);
            $table->string('username', 128)->index();
            $table->string('email', 128)->unique();
            $table->string('password', 128);
            $table->string('salt', 50);
            $table->integer('is_builtin')->default(0);
            $table->integer('is_active')->default(0);
            $table->integer('verified')->default(0);
            $table->dateTime('expire_date')->nullable();
            $table->string('time_zone', 64)->nullable();
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        //Master Table
        Schema::create($prefix . $this->company['table'], function ($table) {
            $table->engine = 'InnoDB';
            $table->increments($this->company['key']);
            $table->string('name', 128)->unique();
            $table->string('email', 128)->unique();
            $table->string('password', 128);
            $table->string('salt', 50);
            $table->integer('is_active')->default(0);
            $table->integer('verified')->default(0);
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        //Master Table
        Schema::create($prefix . $this->api_key_users['table'], function ($table) {
            $table->engine = 'InnoDB';
            $table->increments($this->api_key_users['key']);
            $table->integer('company_id')->unsigned();
            $table->string('apikey', 128)->index()->unique();
            $table->string('secretkey', 128)->index()->unique();
            $table->foreign('company_id')->references($this->company['key'])->on($this->prefix . $this->company['table']);
            $table->timestamps();
            $table->softDeletes();
        });

        //Master Table
        Schema::create($prefix . $this->users_fields_groups['table'], function ($table) {
            $table->engine = 'InnoDB';
            $table->increments($this->users_fields_groups['key']);
            $table->string('group_name', 50)->index()->unique();
            $table->text('group_description')->nullable();
            $table->tinyInteger('group_order')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('admin_use_only')->default(0);
            $table->tinyInteger('is_builtin')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        //Master Table
        Schema::create($prefix . $this->users_fields['table'], function ($table) use ($prefix) {
            $table->engine = 'InnoDB';

            $table->increments($this->users_fields['key']);
            $table->integer('field_type_id')->unsigned();
            $table->integer('group_field_id')->unsigned();
            $table->string('field_name', 50)->index()->unique();
            $table->string('field_label', 50)->index()->unique();
            $table->text('field_comment')->nullable();
            $table->text('possible_values')->nullable();
            $table->string('sort_possible_values', 10)->nullable();
            $table->text('text_select_value')->nullable();
            $table->tinyInteger('is_mandatory')->default(0);
            $table->tinyInteger('field_order')->default(0);
            $table->tinyInteger('sort_values')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('show_in_signup')->default(0);
            $table->tinyInteger('admin_use_only')->default(0);
            $table->tinyInteger('is_encrypted')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('field_type_id')->references('id_field_type')->on($prefix . $this->field_types['table']);
            $table->foreign('group_field_id')->references('id_group_field')->on($prefix . $this->users_fields_groups['table']);

        });

        //Master Table
        Schema::create($prefix . $this->users_groups['table'], function ($table) use ($prefix) {
            $table->engine = 'InnoDB';
            $table->increments($this->users_groups['key']);
            $table->string('named', 50)->index();
            $table->string('coded', 50)->unique();
            $table->text('named_description')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('is_purchaseable')->default(0);
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('time_left')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('period')->unsigned();
            $table->tinyInteger('is_builtin')->default(0);
            $table->string('backcolor', 24);
            $table->string('forecolor', 24);
            $table->foreign('period')->references($this->periode['key'])->on($prefix . $this->periode['table']);
            $table->timestamps();
            $table->softDeletes();
        });

        //Pivot Table
        Schema::create($prefix . $this->users_groups_many['table'], function ($table) use ($prefix) {
            $table->engine = 'InnoDB';
            $table->increments($this->users_groups_many['key']);
            $table->integer('user_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->foreign('user_id')->references($this->users['key'])->on($prefix . $this->users['table']);
            $table->foreign('group_id')->references($this->users_groups['key'])->on($prefix . $this->users_groups['table']);
            $table->timestamps();
        });

        //Pivot Table
        Schema::create($prefix . $this->users_fields_many['table'], function ($table) use ($prefix) {
            $table->engine = 'InnoDB';
            $table->increments($this->users_fields_many['key']);
            $table->integer('role_id')->unsigned();
            $table->integer('userfield_id')->unsigned();
            $table->foreign('role_id')->references($this->users_groups['key'])->on($prefix . $this->users_groups['table']);
            $table->foreign('userfield_id')->references($this->users_fields['key'])->on($prefix . $this->users_fields['table']);
            $table->timestamps();
        });

        //Master Table
        Schema::create($prefix . $this->users_fields_value['table'], function ($table) use ($prefix) {
            $table->engine = 'InnoDB';
            $table->increments($this->users_fields_value['key']);
            $table->integer('user_id')->unsigned();
            $table->integer('custom_fields_id')->unsigned();
            $table->text('field_value')->nullable();
            $table->foreign('user_id')->references($this->users['key'])->on($prefix . $this->users['table']);
            $table->foreign('custom_fields_id')->references($this->users_fields['key'])->on($prefix . $this->users_fields['table']);

            $table->timestamps();
            $table->softDeletes();
        });

        //Pivot Table
        Schema::create($prefix . $this->users_permissions_many['table'], function ($table) use ($prefix) {
            $table->engine = 'InnoDB';
            $table->increments($this->users_permissions_many['key']);
            $table->integer('role_id')->unsigned();
            $table->integer('perm_id')->unsigned();

            $table->foreign('role_id')->references($this->users_groups['key'])->on($prefix . $this->users_groups['table']);
            $table->foreign('perm_id')->references($this->users_permissions['key'])->on($prefix . $this->users_permissions['table']);
            $table->timestamps();
        });

        //Pivot Table
        Schema::create($prefix . $this->users_activation_many['table'], function ($table) use ($prefix) {
            $table->engine = 'InnoDB';
            $table->increments($this->users_activation_many['key']);
            $table->integer('user_id')->unsigned();
            $table->integer('activation_id')->unsigned();

            $table->foreign('user_id')->references($this->users['key'])->on($prefix . $this->users['table']);
            $table->foreign('activation_id')->references($this->activation_users['key'])->on($prefix . $this->activation_users['table']);
            $table->timestamps();

        });

        //Pivot Table
        Schema::create($prefix . $this->company_activation_many['table'], function ($table) use ($prefix) {
            $table->engine = 'InnoDB';
            $table->increments($this->company_activation_many['key']);
            $table->integer('company_id')->unsigned();
            $table->integer('activation_id')->unsigned();

            $table->foreign('company_id')->references($this->company['key'])->on($prefix . $this->company['table']);
            $table->foreign('activation_id')->references($this->activation_users['key'])->on($prefix . $this->activation_users['table']);
            $table->timestamps();
        });

        //Pivot Table
        Schema::create($prefix . $this->users_menus_many['table'], function ($table) use ($prefix) {
            $table->engine = 'InnoDB';
            $table->increments($this->users_menus_many['key']);
            $table->integer('group_id')->unsigned();
            $table->integer('menu_id')->unsigned();
            $table->string('is_check', 15)->default('false')->nullable();

            $table->foreign('group_id')->references($this->users_groups['key'])->on($prefix . $this->users_groups['table']);
            $table->foreign('menu_id')->references($this->users_menus['key'])->on($prefix . $this->users_menus['table']);
            $table->timestamps();
        });

        //========================== STOP =========================================//
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        $prefix = $this->prefix;

        //-- DETAIL --//
        Schema::drop($prefix . $this->company_activation_many['table']);
        Schema::drop($prefix . $this->users_groups_many['table']);
        Schema::drop($prefix . $this->users_domains_many['table']);
        Schema::drop($prefix . $this->users_fields_many['table']);
        Schema::drop($prefix . $this->users_fields_value['table']);
        Schema::drop($prefix . $this->users_permissions_many['table']);
        Schema::drop($prefix . $this->users_menus_many['table']);
        Schema::drop($prefix . $this->users_fields_domains_many['table']);
        Schema::drop($prefix . $this->users_activation_many['table']);
        Schema::drop($prefix . $this->company_activation_many['table']);

        //-- MASTER --//
        Schema::drop($prefix . $this->periode['table']);
        Schema::drop($prefix . $this->field_types['table']);
        Schema::drop($prefix . $this->users_permissions['table']);
        Schema::drop($prefix . $this->users['table']);
        Schema::drop($prefix . $this->users_fields_groups['table']);
        Schema::drop($prefix . $this->users_fields['table']);
        Schema::drop($prefix . $this->company['table']);
        Schema::drop($prefix . $this->users_menus['table']);
        Schema::drop($prefix . $this->users_menus['table']);

    }

}
