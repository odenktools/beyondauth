<?php

namespace Pribumi\BeyondAuth\Models;

use Illuminate\Database\Eloquent\Model;
use Pribumi\BeyondAuth\Traits\BeyondTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pribumi\BeyondAuth\Exceptions\UserFieldGroupDoesNotExist;

/**
 * [MASTER].
 *
 * Class UserFieldGroup
 *
 * Model yang di-peruntukan mengatur Grouping `UserField`.
 * Group ini dimisalkan :
 * #. Group Personal,
 * #. Group Payment
 * #. Group Informasi Geo Tagging
 *
 * @version    1.0.0
 *
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 *
 * @link       http://pribumitech.com
 */
class UserFieldGroup extends Model
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
        'group_name',
        'group_description',
        'group_order',
        'is_active',
        'admin_use_only',
        'is_builtin',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('beyondauth.tables.masters.users_fields_groups', 'users_fields_groups');
        $this->primaryKey = config('beyondauth.tables.keys.masters.users_fields_groups', 'id_group_field');
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
     * [Direct Access Model].
     *
     * Cari data berdasarkan field yang ditentukan
     *
     * @param string $field `nama field` dari table `users_fields_groups`
     * @param string $value `nilai value` yang akan dicari
     *
     * @throws UserFieldGroupDoesNotExist
     *
     * @return UserFieldGroup
     */
    public static function findUserGroupByWhere($field, $value)
    {
        $data = static::where($field, $value)->first();

        if (! $data) {
            throw new UserFieldGroupDoesNotExist("Data dengan value `$value` tidak ditemukan.");
        }

        return $data;
    }

    /**
     * [Non-Direct Access Model].
     *
     * Cari data berdasarkan field yang ditentukan
     *
     * <code>
     * $domain = new \Pribumi\BeyondAuth\Models\UserFieldGroup();
     * $domains = $domain->findByWhere("group_name", "Personal");
     * echo json_encode($domains);
     * </code>
     *
     * @param string $field `nama field` dari table domain
     * @param string $value `nilai value` yang akan dicari
     *
     * @throws UserFieldGroupDoesNotExist
     *
     * @return UserFieldGroup
     */
    public function findByWhere($field, $value)
    {
        return static::findUserGroupByWhere($field, $value);
    }
}
