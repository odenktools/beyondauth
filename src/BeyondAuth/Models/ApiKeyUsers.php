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
    protected static $companyModel = 'Pribumi\BeyondAuth\Models\Company';

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
        'apikey',
        'secretkey',
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
     * Relasi table `Company`.
     *
     * <code>
     * $api = new \Pribumi\BeyondAuth\Models\ApiKeyUsers();
     * $findBy = $api->find(1);
     * echo json_encode($findBy->companies);
     *
     * atau
     * $api = new \Pribumi\BeyondAuth\Models\ApiKeyUsers();
     * $findBy = $api->with('companies')->get();
     * echo json_encode($findBy);
     * </code>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function companies()
    {
        return $this->hasOne(static::$companyModel, 'id_company', 'company_id');
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

    public function findByWhere($field, $value)
    {
        return static::findByFields($field, $value);
    }
}
