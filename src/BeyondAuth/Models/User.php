<?php

namespace Pribumi\BeyondAuth\Models;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Pribumi\BeyondAuth\Exceptions\UserNotExist;

/**
 * [MASTER]
 *
 * Class User
 *
 * @package Pribumi\BeyondAuth\Models
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 * @link       http://pribumitech.com
 */
class User extends Authenticatable
{
    use SoftDeletes;

    /**
     * Nama Primary Key yang digunakan oleh table
     *
     * @var string
     */
    protected $primaryKey = '';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'activation_code',
        'is_builtin',
        'is_active',
        'verified',
        'expire_date',
        'time_zone',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'salt',
        'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The Eloquent role model.
     *
     * @var string
     */
    protected static $userFields = 'Pribumi\BeyondAuth\Models\UserFieldValue';

    /**
     * The Eloquent role model.
     *
     * @var string
     */
    protected static $userGroup = 'Pribumi\BeyondAuth\Models\UserGroup';

    /**
     * The Eloquent UserActivation model.
     *
     * @var string
     */
    protected static $userActivation = 'Pribumi\BeyondAuth\Models\UserActivation';

    /**
     * The Eloquent UserActivation model.
     *
     * @var string
     */
    protected static $apiKeyUsers = 'Pribumi\BeyondAuth\Models\ApiKeyUsers';

    /**
     * The user role pivot table name.
     *
     * @var string
     */
    protected static $userGroupPivot = 'users_groups_many';

    /**
     * The user role pivot table name.
     *
     * @var string
     */
    protected static $userActivationPivot = 'users_activation_many';

    /**
     * The user role pivot table name.
     *
     * @var string
     */
    protected static $userFieldsPivot = 'users_fields_value';

    /**
     * The user apikey pivot table name.
     *
     * @var string
     */
    protected static $apiKeyUsersManyPivot = 'api_key_users_many';

    /**
     * Temporary Permission Cache
     */
    protected $to_check_cache = null;

    /**
     * Temporary Permission Cache
     */
    protected $default_role_name = null;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->table             = config('beyondauth.tables.masters.users', 'users');
        $this->primaryKey        = config('beyondauth.tables.keys.masters.users', 'id_users');
        $this->default_role_name = config('beyondauth.default_role_name', 'member');
    }

    public function getPrimary()
    {
        return $this->primaryKey;
    }

    public function getDefaultRoleName()
    {
        return $this->default_role_name;
    }

    /**
     * [SAAT MEMBUAT RELASI PADA KELAS INI HARUSLAH MEMBUAT RELASI DI KELAS YANG DITUJU]
     * Relasi table users dan roles.
     *
     * <code>
     * $users = new \Pribumi\BeyondAuth\Models\User();
     * $findIdUsers = $users->find(1);
     * echo json_encode($findIdUsers->roles);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Models\UserGroup::users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(static::$userGroup, static::$userGroupPivot, 'user_id', 'group_id')->withTimestamps();
    }

    public function uservalues()
    {
        //return $this->hasMany(static::$userFields, 'user_id');
        return $this->belongsToMany(static::$userFields, static::$userFieldsPivot, 'user_id', 'custom_fields_id')->withTimestamps();
    }

    /**
     * @todo
     *
     * <code>
     * $activations = \Pribumi\BeyondAuth\Models\User::find(1)->activations;
     * echo json_encode($activations);
     * </code>
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function activations()
    {
        return $this->belongsToMany(static::$userActivation, static::$userActivationPivot, 'user_id', 'activation_id')
            ->withTimestamps();
    }

    /**
     * @todo
     *
     * <code>
     * $apikeys = \Pribumi\BeyondAuth\Models\User::find(1)->apikeys;
     * echo json_encode($apikeys);
     * </code>
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function apikeys()
    {
        return $this->belongsToMany(static::$apiKeyUsers, static::$apiKeyUsersManyPivot, 'user_id', 'user_api_key')
            ->withTimestamps();
    }

    public function getToCheck()
    {
        if (empty($this->to_check_cache)) {
            $key = static::getKeyName();

            $to_check = static::with(['roles', 'usergroup.permissions'])
                ->where($key, '=', $this->attributes[$key])
                ->first();
            $this->to_check_cache = $to_check;
        } else {
            $to_check = $this->to_check_cache;
        }

        return $to_check;
    }

    /**
     * Checking User has one or more role??
     *
     */
    public function hasAnyRole()
    {
        $data = $this->roles->first();
        if ($data === null) {
            return false;
        }
        return true;
    }

    /**
     * Check role is purchaseable?
     *
     * @return bool
     */
    public function roleIsActive()
    {
        $data = $this->roles->first();
        if ($data === null) {
            return false;
        }
        if ($data->is_active == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return boolean
     */
    public function isVerified()
    {
        if ($this->verified == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return boolean
     */
    public function isActivated()
    {
        if ($this->is_active == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check role is purchaseable?
     *
     * <code>
     * $purchased = Pribumi\Stoplite\Models\User::purchaseable()->get();
     * echo $purchased
     * </code>
     * @return bool
     */
    public function isPurchaseable()
    {
        $data = $this->roles->first();
        if ($data->is_purchaseable == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Calculate Role Expired
     *
     * @return string
     */
    public function calculateDays()
    {
        //$now = date('Y-m-d H:i:s');

        $now = Carbon::now();

        $row = $this->roles->first();

        $periode = $row->periodes->first();

        if ($periode) {
            switch ($periode->code_periode) {

                //By Seconds
                case "SC":
                    $diff = $now->addSeconds($row->time_left);
                    break;

                //By Minutes
                case "MN":
                    $diff = $now->addMinutes($row->time_left);
                    break;

                //By Days
                case "D":
                    $diff = $now->addDays($row->time_left);
                    break;

                //By Weeks
                case "W":
                    $diff = $now->addWeeks($row->time_left);
                    break;

                //By Month
                case "M":
                    $diff = $now->addMonths($row->time_left);
                    break;

                //By Years
                case "Y":
                    $diff = $now->addYears($row->time_left);
                    break;
            }

            $expire = $diff;
            //$expire = date("Y-m-d H:i:s", strtotime($now . +$diff . " day"));

        } else {

            $expire = "0000-00-00 00:00:00";
        }

        return $expire;
    }

    /**
     * Check User expired?
     *
     * @param $user_id
     * @return bool
     */
    public function isExpired($user_id)
    {
        $data = DB::table($this->getTable())
            ->select('expire_date')->where($this->getKeyName(), $user_id)
            ->whereRaw('TO_DAYS(`expire_date`) > TO_DAYS(NOW())')
            ->first();

        if ($data) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * [Direct Access Model]
     *
     * Cari data berdasarkan field yang ditentukan
     * Metode sama dengan Default Laravel, see
     * @see https://laravel.com/docs/5.3/eloquent#retrieving-models
     *
     * @param string $field `nama field` dari table domain
     * @param string $value `nilai value` yang akan dicari
     *
     * @return User
     *
     * @throws UserNotExist
     */
    public static function findByFields($field, $value)
    {
        $data = static::where($field, $value)->first();

        if (!$data) {
            throw new UserNotExist("Data dengan value ''$value'' tidak ditemukan.");
        }

        return $data;
    }

    /**
     * [Direct Access Model]
     *
    $model = \BeyondAuth::users()
    ->findsBy('email','odenktools86@gmail.com')
    ->orderBy('id_users', 'desc')
    ->take(10)
    ->first();
    echo json_encode( $model->apikeys);
     *
     * Cari data berdasarkan field yang ditentukan
     * Metode sama dengan Default Laravel, see
     * @see https://laravel.com/docs/5.3/eloquent#retrieving-models
     *
     * @param string $field `nama field` dari table domain
     * @param string $value `nilai value` yang akan dicari
     *
     * @return User
     *
     * @throws UserNotExist
     */
    public function findsBy($field, $value)
    {
        $data = static::where($field, $value);
        return $data;
    }

    /**
     * Find a users by its email.
     *
     * @param string $email
     *
     * @return User
     *
     * @throws UserNotExist
     */
    public static function findByEmail($email)
    {
        $email = static::where('email', $email)->first();

        if (!$email) {
            throw new UserNotExist();
        }

        return $email;
    }

    /**
     * Find a activation users by its activation_code.
     * @param $activationCode
     *
     * @return UserActivation
     */
    protected function getStoredActivation($activationCode)
    {
        if (is_string($activationCode)) {
            return app(UserActivation::class)->findByActivation($activationCode);
        }

        return $activationCode;
    }

    /**
     * <code>
     * $user = User::findByEmail('member@pribumitech.com');
     * $user->attachActivation('123123123123');
     * </code>
     *
     * @param string $activationCode
     * @return mixed
     *
     */
    public function attachActivation($activationCode)
    {
        $this->activations()->save($this->getStoredActivation($activationCode));
    }
    /**
     * Cari data member berdasarkan activationcode
     *
     * @param $activationCode
     * @return ActivationMember
     */
    public function whereActivationCode($activationCode)
    {
        $data = $this->getStoredActivation($activationCode);
        return $data;
    }
    /**
     * Remove custom field data
     *
     * @param $activationCode
     * @return int
     */
    public function detachActivation($activationCode)
    {
        $data = $this->activations()->detach($activationCode);
        return $data;
    }

    /**
     * Find a role member by its code_role.
     * @param $codeRole
     *
     * @return UserGroup
     */
    protected function getStoredRole($codeRole)
    {
        if (is_string($codeRole)) {
            return app(UserGroup::class)->findByWhere("coded", $codeRole);
        }

        return $codeRole;
    }

    /**
     * Find a role member by its code_role.
     * @param $keycode
     *
     * @return ApiKeyUsers
     */
    protected function getStoredApiKey($keycode)
    {
        if (is_string($keycode)) {
            return app(ApiKeyUsers::class)->findByWhere("key_code", $keycode);
        }
        return $keycode;
    }

    /**
     * <code>
     * $member = User::findByName('member');
     * $member->attachRole('livetime');
     * </code>
     *
     * @param string $roleName
     * @return mixed
     *
     */
    public function attachRole($roleName)
    {
        $this->roles()->save($this->getStoredRole($roleName));
    }

    /**
     * <code>
     * $member = User::findByName('member');
     * $member->attachApiKey('000001029564239');
     * </code>
     *
     * @param string $keycode
     * @return mixed
     *
     */
    public function attachApiKey($keycode)
    {
        $this->apikeys()->save($this->getStoredApiKey($keycode));
    }
}
