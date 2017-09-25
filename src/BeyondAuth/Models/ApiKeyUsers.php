<?php

namespace Pribumi\BeyondAuth\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Pribumi\BeyondAuth\Exceptions\ApiKeyUsersDoesNotExist;
use Pribumi\BeyondAuth\Traits\BeyondTrait;

/**
 * @todo
 * @license MIT
 */
class ApiKeyUsers extends BaseModels
{
    use BeyondTrait;

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
     * Eloquent `Users` model.
     *
     * @var string
     */
    protected static $usersModel = 'Pribumi\BeyondAuth\Models\User';

    /**
     * Pivot table `users_fields_domains_many`.
     *
     * @var string
     */
    protected static $apiKeyUsersManyPivot = 'api_key_users_many';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key_code',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->table      = config('beyondauth.tables.masters.api_key_users', 'api_key_users');
        $this->primaryKey = config('beyondauth.tables.keys.masters.api_key_users', 'id_key');
    }

    /**
     * @todo
     *
     * <code>
     * $users = \Pribumi\BeyondAuth\Models\ApiKeyUsers::find(1)->users;
     * echo json_encode($users);
     *
     * or
     *
     * $users = \Pribumi\BeyondAuth\Models\ApiKeyUsers::findByActivation("98988889")->users;
     * echo json_encode($users);
     * </code>
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(static::$usersModel, static::$apiKeyUsersManyPivot, 'user_api_key', 'user_id');
    }

    /**
     * [Direct Access Model]
     *
     * Cari data berdasarkan field yang ditentukan
     *
     * @param string $field `nama field` dari table domain
     * @param string $value `nilai value` yang akan dicari
     *
     * @return UserGroup
     *
     * @throws ApiKeyUsersDoesNotExist
     */
    public static function findByFields($field, $value)
    {
        $data = static::where($field, $value)->first();

        if (!$data) {
            throw new ApiKeyUsersDoesNotExist("Data dengan value ''$value'' tidak ditemukan.");
        }

        return $data;
    }

    /**
     * Find a member by its activation_code.
     *
     * @param string $keyCode
     *
     * @return ApiKeyUsers
     *
     * @throws ApiKeyUsersDoesNotExist
     */
    public static function findByActivation($keyCode)
    {
        $role = static::findByFields('key_code', $keyCode)->first();

        if (!$role) {
            throw new ApiKeyUsersDoesNotExist();
        }
        return $role;
    }

    public function findByWhere($field, $value)
    {
        return static::findByFields($field, $value);
    }
}
