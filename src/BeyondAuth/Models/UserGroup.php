<?php

namespace Pribumi\BeyondAuth\Models;

use Illuminate\Database\Eloquent\Model;
use Pribumi\BeyondAuth\Traits\BeyondTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pribumi\BeyondAuth\Exceptions\UserRoleDoesNotExist;

/**
 * [MASTER].
 *
 * Class UserGroup
 *
 * Model yang di-peruntukan mengatur `Role` atau `Group` pada system user
 *
 * @version    1.0.0
 *
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 *
 * @link       http://pribumitech.com
 */
class UserGroup extends Model
{
    use SoftDeletes, BeyondTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '';

    /**
     * Nama Primary Key yang digunakan oleh table.
     *
     * @var string
     */
    protected $primaryKey = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'named',
        'coded',
        'named_description',
        'is_active',
        'is_purchaseable',
        'price',
        'time_left',
        'quantity',
        'period',
        'is_builtin',
        'backcolor',
        'forecolor',
        'created_at',
        'updated_at',
    ];

    /**
     * Eloquent `User` model.
     *
     * @var string
     */
    protected static $userModel = 'Pribumi\BeyondAuth\Models\User';

    /**
     * Pivot table `users_groups_many`.
     *
     * @var string
     */
    protected static $userRolePivot = 'users_groups_many';

    /**
     * Eloquent `User` model.
     *
     * @var string
     */
    protected static $userMenusModel = 'Pribumi\BeyondAuth\Models\UserMenus';

    /**
     * Eloquent `UserPermission` model.
     *
     * @var string
     */
    protected static $userPermissionModel = 'Pribumi\BeyondAuth\Models\UserPermission';

    /**
     * Pivot table `users_menus_many`.
     *
     * @var string
     */
    protected static $userMenusPivot = 'users_menus_many';

    /**
     * Pivot table `users_permissions_many`.
     *
     * @var string
     */
    protected static $userPermissionPivot = 'users_permissions_many';

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('beyondauth.tables.masters.users_groups', 'users_groups');
        $this->primaryKey = config('beyondauth.tables.keys.masters.users_groups', 'id');
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
     * Relasi table roles dan users.
     *
     * <code>
     * $model = new \Pribumi\BeyondAuth\Models\UserGroup();
     * $findBy = $model->find(1);
     * echo json_encode($findBy->users);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Models\User::roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(static::$userModel, static::$userRolePivot, 'user_id', 'group_id')->withTimestamps();
    }

    /**
     * Relasi table roles dan permissions.
     *
     * <code>
     * $model = new \Pribumi\BeyondAuth\Models\UserGroup();
     * $findBy = $model->find(1);
     * echo json_encode($findBy->permissions);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Models\User::roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(static::$userPermissionModel, static::$userPermissionPivot, 'role_id', 'perm_id')->withTimestamps();
    }

    /**
     * Relasi dengan table `periode`.
     *
     * <code>
     * $model = new \Pribumi\BeyondAuth\Models\UserGroup();
     * $findBy = $model->find(1);
     * echo json_encode($findBy->periodes);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Models\Periode::userroles
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function periodes()
    {
        return $this->hasMany('\Pribumi\BeyondAuth\Models\Periode', 'id_periode', 'period');
    }

    /**
     * Relasi table `user menus` dan `user group`.
     *
     * <code>
     * $model = new \Pribumi\BeyondAuth\Models\UserGroup();
     * $findBy = $model->find(1);
     * echo json_encode($findBy->usermenus);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Models\User::roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usermenus()
    {
        return $this->belongsToMany(static::$userMenusModel, static::$userMenusPivot, 'group_id', 'menu_id')->withPivot('is_check')->withTimestamps();
    }

    /**
     * [Direct Access Model].
     *
     * Cari data berdasarkan field yang ditentukan
     *
     * @param string $field `nama field` dari table domain
     * @param string $value `nilai value` yang akan dicari
     *
     * @throws UserRoleDoesNotExist
     *
     * @return UserGroup
     */
    public static function findUserRoleByWhere($field, $value)
    {
        $data = static::where($field, $value)->first();

        if (! $data) {
            throw new UserRoleDoesNotExist("Data dengan value ''$value'' tidak ditemukan.");
        }

        return $data;
    }

    /**
     * [Non-Direct Access Model].
     *
     * Cari data berdasarkan field yang ditentukan
     *
     * <code>
     * $model = new \Pribumi\BeyondAuth\Models\UserGroup();
     * $data = $model->findByWhere("named", "Super Admin");
     * echo json_encode($data);
     * </code>
     *
     * @param string $field `nama field` dari table `users_groups`
     * @param string $value `nilai value` yang akan dicari
     *
     * @throws UserRoleDoesNotExist
     *
     * @return UserGroup
     */
    public function findByWhere($field, $value)
    {
        return static::findUserRoleByWhere($field, $value);
    }
}
