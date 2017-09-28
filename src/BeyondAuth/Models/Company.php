<?php

namespace Pribumi\BeyondAuth\Models;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Pribumi\BeyondAuth\Exceptions\CompanyNotExist;

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
class Company extends Authenticatable
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
        'name',
        'email',
        'password',
        'activation_code',
        'is_builtin',
        'is_active',
        'verified',
        'last_login'
    ];

    /**
     * Eloquent `ApiKeyUsers` model.
     *
     * @var string
     */
    protected static $apiKeyModel = 'Pribumi\BeyondAuth\Models\ApiKeyUsers';

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
     * The Eloquent UserActivation model.
     *
     * @var string
     */
    protected static $userActivation = 'Pribumi\BeyondAuth\Models\UserActivation';

    /**
     * The user role pivot table name.
     *
     * @var string
     */
    protected static $companyActivationPivot = 'company_activation_many';

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->table             = config('beyondauth.tables.masters.company', 'company');
        $this->primaryKey        = config('beyondauth.tables.keys.masters.company', 'id_company');
    }

    public function getPrimary()
    {
        return $this->primaryKey;
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
        return $this->belongsToMany(static::$userActivation, static::$companyActivationPivot, 'company_id', 'activation_id')
            ->withTimestamps();
    }

    /**
     * Relasi table `Company`.
     *
     * <code>
     * $company = new \Pribumi\BeyondAuth\Models\Company();
     * $findBy = $company->find(1);
     * echo json_encode($findBy->apikeys);
     *
     * atau
     * $company = new \Pribumi\BeyondAuth\Models\Company();
     * $findBy = $company->with('apikeys')->get();
     * echo json_encode($findBy);
     * </code>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function apikeys()
    {
        return $this->hasOne(static::$apiKeyModel, 'company_id', 'id_company');
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
     * @throws CompanyNotExist
     */
    public static function findByFields($field, $value)
    {
        $data = static::where($field, $value)->first();

        if (!$data) {
            throw new CompanyNotExist("Data dengan value ''$value'' tidak ditemukan.");
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
     * @throws CompanyNotExist
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
     * @throws CompanyNotExist
     */
    public static function findByEmail($email)
    {
        $email = static::where('email', $email)->first();

        if (!$email) {
            throw new CompanyNotExist();
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
}
