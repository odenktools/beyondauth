<?php

namespace Pribumi\BeyondAuth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pribumi\BeyondAuth\Traits\BeyondTrait;

/**
 * Class FieldTypes.
 *
 * Model yang di-peruntukan mengatur tipe-tipe data
 * pada `custom fields`.
 *
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 */
class FieldTypes extends Model
{
    use SoftDeletes, BeyondTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'field_types';

    /**
     * Nama Primary Key yang digunakan oleh table.
     *
     * @var string
     */
    protected $primaryKey = 'id_field_type';

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
        'field_name',
        'code_field_types',
        'field_description',
        'field_size',
        'created_at',
        'updated_at',
    ];

    /**
     * The Eloquent user model.
     *
     * @var string
     */
    protected static $userFieldModel = 'Pribumi\BeyondAuth\Models\UserField';

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->table      = config('beyondauth.tables.masters.field_types', 'field_types');
        $this->primaryKey = config('beyondauth.tables.keys.masters.field_types', 'id_field_type');
    }

    /**
     * Relasi dengan table `UserGroup`.
     *
     * <code>
     * $fieldType = new \Pribumi\BeyondAuth\Models\FieldTypes();
     * $fieldTypes = $fieldType->find(1);
     * $get_usergroups = $fieldTypes->usergroups->all();
     * </code>
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usergroups()
    {
        return $this->hasMany(static::$userFieldModel, 'field_type_id');
    }
}
