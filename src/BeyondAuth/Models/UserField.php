<?php

namespace Pribumi\BeyondAuth\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pribumi\BeyondAuth\Exceptions\UserFieldDoesNotExist;
use Pribumi\BeyondAuth\Traits\BeyondTrait;

/**
 * [MASTER]
 *
 * Class UserField
 *
 * Model yang di-peruntukan membuat field secara dinamis pada system user
 *
 * @package Pribumi\BeyondAuth\Models
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 * @link       http://pribumitech.com
 */
class UserField extends Model
{

    use SoftDeletes, BeyondTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '';

    /**
     * Nama Primary Key yang digunakan oleh table
     *
     * @var string
     */
    protected $primaryKey = '';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'field_type_id',
        'group_field_id',
        'field_name',
        'field_label',
        'field_comment',
        'possible_values',
        'text_select_value',
        'is_mandatory',
        'field_order',
        'sort_values',
        'is_active',
        'show_in_signup',
        'admin_use_only',
        'is_encrypted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Eloquent `FieldTypes` model.
     *
     * @see \Pribumi\BeyondAuth\Models\FieldTypes
     * @var string
     */
    protected static $fieldTypesModel = 'Pribumi\BeyondAuth\Models\FieldTypes';

    /**
     * Eloquent `UserGroup` model.
     *
     * @var string
     */
    protected static $userGroupModel = 'Pribumi\BeyondAuth\Models\UserGroup';

    /**
     * Pivot table `users_fields_many`.
     *
     * @var string
     */
    protected static $userGroupPivot = 'users_fields_many';

    /**
     * Eloquent `UserFieldGroup` model.
     *
     * @see \Pribumi\BeyondAuth\Models\UserFieldGroup
     * @var string
     */
    protected static $userFieldGroupModel = 'Pribumi\BeyondAuth\Models\UserFieldGroup';

    /**
     * Eloquent `UserFieldValue` model.
     *
     * @see \Pribumi\BeyondAuth\Models\UserFieldValue
     * @var string
     */
    protected static $userFieldValueModel = 'Pribumi\BeyondAuth\Models\UserFieldValue';

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->table      = config('beyondauth.tables.masters.users_fields', 'users_fields');
        $this->primaryKey = config('beyondauth.tables.keys.masters.users_fields', 'id_custom_fields');
    }

    /**
     * Dapatkan primarykey.
     *
     * @return string
     */
    public function primary()
    {
        return $this->primaryKey;
    }

    /**
     * Relasi table `FieldTypes`.
     *
     * <code>
     * $userField = new \Pribumi\BeyondAuth\Models\UserField();
     * $findBy = $userField->find(1);
     * echo json_encode($findBy->fieldtypes->all());
     *
     * atau
     * $userField = new \Pribumi\BeyondAuth\Models\UserField();
     * $findBy = $userField->with('fieldtypes')->get();
     * echo json_encode($findBy);
     * </code>
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fieldtypes()
    {
        return $this->hasOne(static::$fieldTypesModel, 'id_field_type', 'field_type_id');
    }

    /**
     * Relasi table userfield dan role.
     *
     * <code>
     * $model = new \Pribumi\BeyondAuth\Models\UserField();
     * $findBy = $model->find(1);
     * echo json_encode($findBy->usergroups);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Models\UserGroup::userfields
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usergroups()
    {
        return $this->belongsToMany(static::$userGroupModel, static::$userGroupPivot,
            'userfield_id', 'role_id', 'id_custom_fields')->withTimestamps();
    }

    /**
     * Relasi table `FieldTypes`.
     *
     * <code>
     * $userField = new \Pribumi\BeyondAuth\Models\UserField();
     * $findBy = $userField->find(1);
     * echo json_encode($findBy->fieldvalues->all());
     *
     * atau
     * $userField = new \Pribumi\BeyondAuth\Models\UserField();
     * $findBy = $userField->with('fieldvalues')->get();
     * echo json_encode($findBy);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Models\FieldTypes::usergroups
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fieldvalues()
    {
        $primary = config('beyondauth.tables.keys.masters.users_fields_value', '');
        return $this->hasOne(static::$userFieldValueModel, $primary, 'custom_fields_id');
    }

    /**
     * Relasi table `UserFieldGroup`.
     *
     * <code>
     * $userField = new \Pribumi\BeyondAuth\Models\UserField();
     * $findBy = $userField->find(1);
     * echo json_encode($findBy->userfieldgroups->all());
     *
     * (atau)
     *
     * $userField = new \Pribumi\BeyondAuth\Models\UserField();
     * $findBy = $userField->with('userfieldgroups')->get();
     * echo json_encode($findBy);
     *
     * </code>
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userfieldgroups()
    {
        return $this->hasOne(static::$userFieldGroupModel, 'id_group_field', 'group_field_id');
    }

    /**
     * [Direct Access Model]
     *
     * Cari data berdasarkan field yang ditentukan
     *
     * @param string $field `nama field` dari `table userfield`
     * @param string $value `nilai value` yang akan dicari
     *
     * @return UserField
     *
     * @throws UserFieldDoesNotExist
     */
    public static function findUserFieldByWhere($field, $value)
    {
        $role = static::where($field, $value)->first();

        if (!$role) {
            throw new UserFieldDoesNotExist("Data dengan value `$value` tidak ditemukan.");
        }

        return $role;
    }

    /**
     * [Non-Direct Access Model]
     *
     * Cari data berdasarkan field yang ditentukan
     *
     * <code>
     * $userfield = new \Pribumi\BeyondAuth\Models\UserField();
     * $userfields = $userfield->findByWhere("field_name", "first_name");
     * echo json_encode($userfields);
     * </code>
     *
     * @param string $field `nama field` dari `table userfield`
     * @param string $value `nilai value` yang akan dicari
     *
     * @return UserField
     *
     * @throws UserFieldDoesNotExist
     */
    public function findByWhere($field, $value)
    {
        return static::findUserFieldByWhere($field, $value);
    }

    public function fetchData($conditions = null, $take = null, $skip = null, $sort = null, $order = null)
    {
        if ($conditions === null) {
            $conditions = " 1 = 1 ";
        }

        $data = DB::table('users_fields as t3')
            ->join('field_types as t5', 't5.id_field_type', '=', 't3.field_type_id')
            ->join('users_fields_groups as t6', 't6.id_group_field', '=', 't3.group_field_id')
            ->select(DB::raw('t3.*', 't6.group_name', 't5.field_name as field_type'))
            ->whereRaw($conditions)
            ->whereNull('t3.deleted_at')
            ->take($take)
            ->skip($skip)
            ->orderBy($sort, $order)
            ->get();

        return $data;
    }

    public function fetchCount($conditions = null)
    {
        if ($conditions === null) {
            $conditions = " 1 = 1 ";
        }

        $data = DB::table('users_fields as t3')
            ->join('field_types as t5', 't5.id_field_type', '=', 't3.field_type_id')
            ->join('users_fields_groups as t6', 't6.id_group_field', '=', 't3.group_field_id')
            ->select(DB::raw('t3.*', 't6.group_name', 't5.field_name as field_type'))
            ->whereRaw($conditions)
            ->whereNull('t3.deleted_at')
            ->count();

        return $data;
    }

    /**
     * [HARUS DI-OPTIMIZE LAGI MENGGUNAKAN ELOQUENT]
     *
     * Dapatkan Custom Fields dari database
     *
     * <code>
     * $userfield = new \Pribumi\BeyondAuth\Models\UserField()
     * $fields = $userfield->getCustomFields('member', 0, 1, 1, 0);
     * echo json_encode($fields);
     * </code>
     *
     * @param string $roleName dapatkan custom berdasarkan role
     * @param string $domainName dapatkan custom fields yang terdapat pada nama domain saja
     * @param int $group_field_id group custom field dari group field apa? personal, payment, etc...
     * @param int $show_in_signup display on signup perlihatkan field yang hanya untuk signup saja?
     * @param int $is_active perlihatkan fields yang aktif?
     * @param int $admin_use_only perlihat fields yang untuk admin saja?
     * @return array
     */
    public function getCustomFields($roleName = '', $group_field_id = 0, 
        $show_in_signup = 1, $is_active = 1,
        $admin_use_only = 0) {

        if ($roleName !== '') {
            $fetchRole = " AND LOWER(t6.`coded`) = LOWER('$roleName') ";
        } else {
            $fetchRole = "";
        }

        if ($group_field_id == 0) {
            $only_group = " ";
        } else {
            $only_group = " AND `group_field_id` = $group_field_id ";
        }

        if ($admin_use_only == 0) {
            $only_admin = " AND (`admin_use_only` = 0 OR `admin_use_only` IS NULL) ";
        } else {
            $only_admin = " AND (`admin_use_only` = 1) ";
        }

        if ($show_in_signup != 1 && $show_in_signup = -1) {
            $fetchSignup = " ";
        } else {
            $fetchSignup = " AND `show_in_signup` = $show_in_signup ";
        }

        $return = DB::select(
            "SELECT
              *
            FROM `users_fields`
            WHERE 1 = 1 AND `id_custom_fields` IN (SELECT
                `id_custom_fields`
              FROM (SELECT
                  t3.`id_custom_fields`
                FROM `users_fields` t3
                  INNER JOIN `users_fields_many` t5
                    ON t5.`userfield_id` = t3.`id_custom_fields`
                  INNER JOIN `users_groups` t6
                    ON t6.`id` = t5.`role_id` $fetchRole
                UNION
                SELECT
                  t3.`id_custom_fields`
                FROM `users_fields` t3
                  LEFT JOIN `users_fields_many` t5
                    ON t5.`userfield_id` = t3.`id_custom_fields`
                  LEFT JOIN `users_groups` t6
                    ON t6.`id` = t5.`role_id`
                WHERE t6.`coded` IS NULL AND t6.`deleted_at` IS NULL) a) 
                $only_group
                $fetchSignup
            AND `users_fields`.`is_active` = $is_active
            $only_admin
            AND (`users_fields`.`deleted_at` IS NULL)
            ORDER BY `users_fields`.`field_order`;"
        );

        return $return;
    }

}
