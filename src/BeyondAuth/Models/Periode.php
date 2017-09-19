<?php

namespace Pribumi\BeyondAuth\Models;

use Illuminate\Database\Eloquent\Model;
use Pribumi\BeyondAuth\Traits\BeyondTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pribumi\BeyondAuth\Exceptions\PeriodeDoesNotExist;

/**
 * [MASTER]
 *
 * Class Periode
 *
 * Model yang di-peruntukan mengatur periode
 * kapan user expire.
 *
 * @package Pribumi\BeyondAuth\Models
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 * @link       http://pribumitech.com
 */
class Periode extends Model
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
        'code_periode',
        'nama_periode',
        'created_at',
        'updated_at'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->table = config('beyondauth.tables.masters.periode', 'periode');
        $this->primaryKey = config('beyondauth.tables.keys.masters.periode', 'id_periode');
    }

    /**
     * Relasi dengan table `UserGroup`
     *
     * <code>
     * $periode = new \Pribumi\BeyondAuth\Models\Periode();
     * $findIdPeriode = $periode->find(1);
     * echo json_encode($findIdPeriode->usergroups);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Models\UserGroup::periodes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usergroups()
    {
        /*(:nama_key_pada_table_relasi)*/
        return $this->hasMany('\Pribumi\BeyondAuth\Models\UserGroup', 'period');
    }

    /**
     * [Direct Access Model]
     *
     * Cari data berdasarkan field yang ditentukan
     *
     * @param string $field `nama field` dari table domain
     * @param string $value `nilai value` yang akan dicari
     *
     * @return Periode
     *
     * @throws PeriodeDoesNotExist
     */
    public static function findPeriodeByWhere($field, $value)
    {
        $data = static::where($field, $value)->first();

        if (!$data) {
            throw new PeriodeDoesNotExist("Data dengan value `$value` tidak ditemukan.");
        }

        return $data;
    }

    /**
     * [Non-Direct Access Model]
     *
     * Cari data berdasarkan field yang ditentukan
     *
     * <code>
     * $periode = new \Pribumi\BeyondAuth\Models\Periode();
     * $periode = $periode->findByWhere("nama_periode", "Hari");
     * echo json_encode($periode);
     * </code>
     *
     * @param string $field `nama field` dari table domain
     * @param string $value `nilai value` yang akan dicari
     *
     * @return Periode
     *
     * @throws PeriodeDoesNotExist
     */
    public function findByWhere($field, $value)
    {
        return static::findPeriodeByWhere($field, $value);
    }

}