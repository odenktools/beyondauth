<?php

namespace Pribumi\BeyondAuth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pribumi\BeyondAuth\Traits\BeyondTrait;
use Pribumi\BeyondAuth\Exceptions\UserFieldDoesNotExist;
use DB;

/**
 * [MASTER]
 *
 * Class UserFieldValue
 *
 * Model yang di-peruntukan menampung data dari userfield
 *
 * @package Pribumi\BeyondAuth\Models
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 * @link       http://pribumitech.com
 */
class UserFieldValue extends Model
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
        'id_custom_fields',
        'user_id',
        'custom_fields_id',
        'field_value',
        'created_at',
        'updated_at',
		'deleted_at'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->table = config('beyondauth.tables.masters.users_fields_value', 'users_fields_value');
        $this->primaryKey = config('beyondauth.tables.keys.masters.users_fields_value', 'id_custom_fields');
    }
    
    /**
     * Eloquent `Users` model.
     *
     * @var string
     */
    protected static $usersModel = 'Pribumi\BeyondAuth\Models\User';
    
    public function users()
    {
        return $this->belongsToMany(static::$usersModel, 'users_fields_value', 'user_id', 'custom_fields_id')
            ->withTimestamps();
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
    public static function findUserFieldValueByWhere($field, $value)
    {
        $data = static::where($field, $value)->first();
        if (!$data) {
            return false;
        }
        return $data;
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
        return static::findUserFieldValueByWhere($field, $value);
    }

}