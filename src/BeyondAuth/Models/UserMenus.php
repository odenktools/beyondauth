<?php

namespace Pribumi\BeyondAuth\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pribumi\BeyondAuth\Exceptions\UserMenusDoesNotExist;
use Pribumi\BeyondAuth\Traits\BeyondTrait;

/**
 * [MASTER]
 *
 * Class UserMenus
 *
 * class untuk mengatur admin menu, seluruh
 * menu mempergunakan class ini.
 *
 * @package Pribumi\BeyondAuth\Models
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 * @link       http://pribumitech.com
 */
class UserMenus extends Model
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
     * Eloquent `UserGroup` model.
     *
     * @var string
     */
    protected static $userGroupModel = 'Pribumi\BeyondAuth\Models\UserGroup';

    /**
     * Pivot table `users_menus_many`.
     *
     * @var string
     */
    protected static $userGroupPivot = 'users_menus_many';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_menu',
        'menu_title',
        'menu_name',
        'backend_route',
        'image',
        'is_active',
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

        $this->table      = config('beyondauth.tables.masters.users_menus', 'users_menus');
        $this->primaryKey = config('beyondauth.tables.keys.masters.users_menus', 'id_menu');
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

/*    public function getMenus()
{
$sql = "SELECT
`child`.`id_menu` AS `id_menu`,
`child`.`parent_menu` AS `parent_menu`,
`child`.`menu_title` AS `menu_title`,
`child`.`menu_name` AS `menu_name`,
`child`.`backend_route` AS `backend_route`,
`child`.`image` AS `image`,
`child`.`is_active` AS `is_active`,
`child`.`menu_order` AS `menu_order`,
`prmn`.`is_check` AS `is_check`,
COUNT(`grandchild`.`parent_menu`) AS `level_count`
FROM `users_menus` `child`

JOIN `users_menus` `parent`
ON `child`.`parent_menu` = `parent`.`id_menu`
AND `parent`.`id_menu` = 1

LEFT JOIN `users_menus` `grandchild`
ON `child`.`id_menu` = `grandchild`.`parent_menu`

JOIN `users_menus_many` `prmn`
ON `child`.`id_menu` = `prmn`.`menu_id`

JOIN `users_groups` `rl`
ON `rl`.`id` = `prmn`.`group_id`

GROUP BY `child`.`id_menu`, `child`.`menu_title`, `child`.`menu_order`
ORDER BY `child`.`menu_order` ASC
;";

$data = DB::select($sql);

if (!$data) {
throw new UserMenusDoesNotExist("Menu tidak tersedia.");
}

return $data;
}*/

    /**
     * Build Main Menu Aplikasi
     *
     * <code>
     * $menus = new \Pribumi\BeyondAuth\Models\UserMenus();
     * $data = menus->getMenus(1,1);
     * echo json_encode($data);
     * </code>
     *
     * @param $user_groups integer Nilai Group dari user
     * @param $id_menu integer Nilai Id Menu
     * @param $active integer Aktif menu tersebut?
     *
     * @return Object
     *
     * @throws UserMenusDoesNotExist
     */
    public function getMenusBy($user_groups = null, $id_menu = 1, $active = 1)
    {
        $tmpUserGroup   = '';
        $is_checked     = ',';
        $cek_permission = '';

        if ($user_groups !== null) {
            $tmpUserGroup = "AND `rl`.`id` = $user_groups";
        }

        if ($user_groups !== null) {
            $is_checked .= "`prmn`.`is_check` AS `is_check`,";
        }

        if ($user_groups !== null) {
            $cek_permission = "JOIN `users_menus_many` `prmn`
			ON `child`.`id_menu` = `prmn`.`menu_id`

		  JOIN `users_groups` `rl`
			ON `rl`.`id` = `prmn`.`group_id`";
        }

        $sql = "SELECT
		  `child`.`id_menu` AS `id_menu`,
		  `child`.`parent_menu` AS `parent_menu`,
		  `child`.`menu_title` AS `menu_title`,
		  `child`.`menu_name` AS `menu_name`,
		  `child`.`backend_route` AS `backend_route`,
		  `child`.`image` AS `image`,
		  `child`.`is_active` AS `is_active`,
		  `child`.`menu_order` AS `menu_order`
		  $is_checked
		  COUNT(`grandchild`.`parent_menu`) AS `level_count`
		FROM `users_menus` `child`

		  JOIN `users_menus` `parent`
			ON `child`.`parent_menu` = `parent`.`id_menu`
			AND `parent`.`id_menu` = $id_menu

		  LEFT JOIN `users_menus` `grandchild`
			ON `child`.`id_menu` = `grandchild`.`parent_menu`

		  $cek_permission

		WHERE 1 = 1 $tmpUserGroup AND `child`.`is_active` = $active
			GROUP BY `child`.`id_menu`, `child`.`menu_title`, `child`.`menu_order`
			ORDER BY `child`.`menu_order` ASC
			;";

        $data = DB::select($sql);

        if (!$data) {
            throw new UserMenusDoesNotExist("Menu tidak tersedia.");
        }

        return $data;
    }

    /**
     * Build Main Menu Aplikasi
     *
     * <code>
     * $menus = new \Pribumi\BeyondAuth\Models\UserMenus();
     * $data = menus->getMenus(1,1);
     * echo json_encode($data);
     * </code>
     *
     * @param $user_groups integer Nilai Group dari user
     * @param $id_menu integer Nilai Id Menu
     * @param $active integer Aktif menu tersebut?
     *
     * @return Object
     *
     * @throws UserMenusDoesNotExist
     */
    public function getSidebar($user_groups, $id_menu = 1, $active = 1)
    {
        /*$tmpUserGroup = '';
        if ($user_groups !== null) {
            $tmpUserGroup = "AND `rl`.`id` = $user_groups";
        }*/

        $sql = "SELECT
		  `child`.`id_menu` AS `id_menu`,
		  `child`.`parent_menu` AS `parent_menu`,
		  `child`.`menu_title` AS `menu_title`,
		  `child`.`menu_name` AS `menu_name`,
		  `child`.`backend_route` AS `backend_route`,
		  `child`.`image` AS `image`,
		  `child`.`is_active` AS `is_active`,
		  `child`.`menu_order` AS `menu_order`,
		  `prmn`.`is_check` AS `is_check`,
		  COUNT(`grandchild`.`parent_menu`) AS `level_count`
		FROM `users_menus` `child`

		  JOIN `users_menus` `parent`
			ON `child`.`parent_menu` = `parent`.`id_menu`
			AND `parent`.`id_menu` = $id_menu

		  LEFT JOIN `users_menus` `grandchild`
			ON `child`.`id_menu` = `grandchild`.`parent_menu`

		  JOIN `users_menus_many` `prmn`
			ON `child`.`id_menu` = `prmn`.`menu_id`

		  JOIN `users_groups` `rl`
			ON `rl`.`id` = `prmn`.`group_id`

		WHERE `rl`.`id` = $user_groups AND `child`.`is_active` = $active AND `prmn`.`is_check` = 'true'
			GROUP BY `child`.`id_menu`, `child`.`menu_title`, `child`.`menu_order`
			ORDER BY `child`.`menu_order` ASC
			;";

        $data = DB::select($sql);

        if (!$data) {
            throw new UserMenusDoesNotExist("Menu tidak tersedia.");
        }

        return $data;
    }

    /**
     * [Direct Access Model]
     *
     * Cari data berdasarkan field yang ditentukan
     *
     * @param string $field `nama field` dari table `users_menus`
     * @param string $value `nilai value` yang akan dicari
     *
     * @return UserMenus
     *
     * @throws UserMenusDoesNotExist
     */
    public static function findUserMenusByWhere($field, $value)
    {
        $data = static::where($field, $value)->first();
        if (!$data) {
            throw new UserMenusDoesNotExist("Data dengan value `$value` tidak ditemukan.");
        }

        return $data;
    }

    /**
     * [Non-Direct Access Model]
     *
     * Cari data berdasarkan field yang ditentukan
     *
     * <code>
     * $menus = new \Pribumi\BeyondAuth\Models\UserMenus();
     * $findBy = $menus->findByWhere("parent_menu", "1");
     * echo json_encode($findBy);
     * </code>
     *
     * @param string $field `nama field` dari table domain
     * @param string $value `nilai value` yang akan dicari
     *
     * @return UserMenus
     *
     * @throws UserMenusDoesNotExist
     */
    public function findByWhere($field, $value)
    {
        return static::findUserMenusByWhere($field, $value);
    }
}
