<?php

namespace Pribumi\BeyondAuth\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pribumi\BeyondAuth\Exceptions\UserPermissionDoesNotExist;
use Pribumi\BeyondAuth\Traits\BeyondTrait;

/**
 * [MASTER]
 *
 * Class UserPermission
 *
 * class untuk mengatur permission user grup
 *
 * @package Pribumi\BeyondAuth\Models
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 * @link       http://pribumitech.com
 */
class UserPermission extends Model
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_permission',
        'readable_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->table      = config('beyondauth.tables.masters.users_permissions', 'users_permissions');
        $this->primaryKey = config('beyondauth.tables.keys.masters.users_permissions', 'id_perm');
    }

    /**
     * [Direct Access Model]
     *
     * Cari data berdasarkan field yang ditentukan
     *
     * @param string $field `nama field` dari table `users_menus`
     * @param string $value `nilai value` yang akan dicari
     *
     * @return UserPermission
     *
     * @throws UserPermissionDoesNotExist
     */
    public static function findUserPermissionByWhere($field, $value)
    {
        $data = static::where($field, $value)->first();
        if (!$data) {
            throw new UserPermissionDoesNotExist("Data dengan value `$value` tidak ditemukan.");
        }

        return $data;
    }

    /**
     * [Non-Direct Access Model]
     *
     * Cari data berdasarkan field yang ditentukan
     *
     * <code>
     * $menus = new \Pribumi\BeyondAuth\Models\UserPermission();
     * $findBy = $menus->findByWhere("name_permission", "user.create");
     * echo json_encode($findBy);
     * </code>
     *
     * @param string $field `nama field` dari table domain
     * @param string $value `nilai value` yang akan dicari
     *
     * @return UserPermission
     *
     * @throws UserPermissionDoesNotExist
     */
    public function findByWhere($field, $value)
    {
        return static::findUserPermissionByWhere($field, $value);
    }
}
