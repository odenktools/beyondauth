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
     * This function implements the algorithm outlined
     * in RFC 6238 for Time-Based One-Time Passwords
     *
     * @link http://tools.ietf.org/html/rfc6238
     * @param string $key    the string to use for the HMAC key
     * @param mixed  $time   a value that reflects a time (unix
     *                       time in the example)
     * @param int    $digits the desired length of the OTP
     * @param string $crypto the desired HMAC crypto algorithm
     * @return string the generated OTP
     */
    public function oauth_totp($key, $time, $digits = 8, $crypto = 'sha256')
    {
        $digits = intval($digits);
        $result = null;

        // Convert counter to binary (64-bit)
        $data = pack('NNC*', $time >> 32, $time & 0xFFFFFFFF);

        // Pad to 8 chars (if necessary)
        if (strlen($data) < 8) {
            $data = str_pad($data, 8, chr(0), STR_PAD_LEFT);
        }

        // Get the hash
        $hash = hash_hmac($crypto, $data, $key);

        // Grab the offset
        $offset = 2 * hexdec(substr($hash, strlen($hash) - 1, 1));

        // Grab the portion we're interested in
        $binary = hexdec(substr($hash, $offset, 8)) & 0x7fffffff;

        // Modulus
        $result = $binary % pow(10, $digits);

        // Pad (if necessary)
        $result = str_pad($result, $digits, "0", STR_PAD_LEFT);

        return $result;
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
