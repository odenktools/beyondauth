<?php

namespace Pribumi\BeyondAuth;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;
use Pribumi\BeyondAuth\Contracts\ApiKeyUsersInterface;
use Pribumi\BeyondAuth\Contracts\CompanyInterface;
use Pribumi\BeyondAuth\Contracts\FieldTypesInterface;
use Pribumi\BeyondAuth\Contracts\PeriodeInterface;
use Pribumi\BeyondAuth\Contracts\UserActivationInterface;
use Pribumi\BeyondAuth\Contracts\UserFieldGroupInterface;
use Pribumi\BeyondAuth\Contracts\UserFieldInterface;
use Pribumi\BeyondAuth\Contracts\UserFieldValueInterface;
use Pribumi\BeyondAuth\Contracts\UserGroupInterface;
use Pribumi\BeyondAuth\Contracts\UserInterface as UserRepository;
use Pribumi\BeyondAuth\Contracts\UserMenuInterface;
use Pribumi\BeyondAuth\Contracts\UserPermissionInterface;
use Pribumi\BeyondAuth\Exceptions\MethodNotExist;

/**
 * Class BeyondAuth Facade.
 *
 * Logic tidak berada disini, lebih baik logic
 * tetap di `Class` masing-masing agar maintenis lebih mudah dilakukan.
 *
 * Perlakukan `Class` ini seperti `Route` di AngularJS atau Laravel.
 * Maksudnya disini adalah definisi tugas-tugas `Model` yang penting.
 *
 * @see : http://docs.odenktools/laravelcleancode
 *
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 */
class BeyondAuth
{
    /**
     * Laravel application.
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * UserInterface.
     *
     * @var \Pribumi\BeyondAuth\Contracts\UserInterface
     */
    public $userRepository;

    /**
     * UserRole Repository.
     *
     * @var \Pribumi\BeyondAuth\Contracts\UserGroupInterface
     */
    public $userGroupRepository;

    /**
     * Periode Repository.
     *
     * @var \Pribumi\BeyondAuth\Contracts\PeriodeRepository
     */
    public $periodeRepository;

    /**
     * UserFieldGroup Repository.
     *
     * @var \Pribumi\BeyondAuth\Contracts\UserFieldGroupInterface
     */
    public $userFieldGroupRepository;

    /**
     * UserField Repository.
     *
     * @var \Pribumi\BeyondAuth\Contracts\UserFieldInterface
     */
    public $userFieldRepository;

    /**
     * UserMenus Repository.
     *
     * @var \Pribumi\BeyondAuth\Contracts\UserMenuRepository
     */
    public $userMenuRepository;

    /**
     * UserMenus Repository.
     *
     * @var \Pribumi\BeyondAuth\Contracts\UserPermissionInterface
     */
    public $userPermissionRepository;

    /**
     * FieldTypes Repository.
     *
     * @var \Pribumi\BeyondAuth\Contracts\FieldTypesInterface
     */
    public $fieldTypesRepository;

    /**
     * UserFieldValueInterface Repository.
     *
     * @var \Pribumi\BeyondAuth\Contracts\UserFieldValueInterface
     */
    public $userFieldValueRepository;

    /**
     * ApiKeyUsersInterface Repository.
     *
     * @var \Pribumi\BeyondAuth\Contracts\ApiKeyUsersInterface
     */
    public $apiKeyUsersRepository;

    /**
     * UserActivationInterface Repository.
     *
     * @var \Pribumi\BeyondAuth\Contracts\UserActivationInterface
     */
    public $userActivationRepository;

    /**
     * CompanyRepository Repository.
     *
     * @var \Pribumi\BeyondAuth\Contracts\CompanyInterface
     */
    public $companyRepository;

    /**
     * BeyondAuth constructor.
     *
     * Dependency Injection(DI), Harus Selalu pergunakan interface (dari \Pribumi\BeyondAuth\Contracts)
     *
     * @param $app Laravel application
     * @param UserRepository          $userRepository           UserRepository repository
     * @param UserGroupInterface      $userGroupInterface       UserGroupInterface repository
     * @param PeriodeInterface        $periodeInterface         PeriodeInterface repository
     * @param UserFieldGroupInterface $userFieldGroupInterface  UserFieldGroupInterface repository
     * @param UserFieldInterface      $userFieldInterface       UserFieldInterface repository
     * @param UserMenuInterface       $userMenuInterface        UserMenuInterface repository
     * @param UserPermissionInterface $userPermissionRepository UserPermissionInterface repository
     * @param FieldTypesInterface     $fieldTypesRepository     FieldTypesInterface repository
     * @param UserFieldValueInterface $userFieldValueRepository UserFieldValueInterface
     * @param UserActivationInterface $userActivationRepository UserActivationInterface
     * @param ApiKeyUsersInterface    $apiKeyUsersRepository    ApiKeyUsersInterface repository
     * @param CompanyInterface        $companyRepository        CompanyInterface repository
     */
    public function __construct(
        $app,
        UserRepository $userRepository,
        UserGroupInterface $userGroupRepository,
        PeriodeInterface $periodeRepository,
        UserFieldGroupInterface $userFieldGroupRepository,
        UserFieldInterface $userFieldRepository,
        UserMenuInterface $userMenuRepository,
        UserPermissionInterface $userPermissionRepository,
        FieldTypesInterface $fieldTypesRepository,
        UserFieldValueInterface $userFieldValueRepository,
        UserActivationInterface $userActivationRepository,
        ApiKeyUsersInterface $apiKeyUsersRepository,
        CompanyInterface $companyRepository
    ) {
        $this->app                      = $app;
        $this->userRepository           = $userRepository;
        $this->userGroupRepository      = $userGroupRepository;
        $this->periodeRepository        = $periodeRepository;
        $this->userFieldGroupRepository = $userFieldGroupRepository;
        $this->userFieldRepository      = $userFieldRepository;
        $this->userMenuRepository       = $userMenuRepository;
        $this->userPermissionRepository = $userPermissionRepository;
        $this->fieldTypesRepository     = $fieldTypesRepository;
        $this->userFieldValueRepository = $userFieldValueRepository;
        $this->apiKeyUsersRepository    = $apiKeyUsersRepository;
        $this->userActivationRepository = $userActivationRepository;
        $this->companyRepository        = $companyRepository;
    }

    /**
     * Create Random String (42 karakter).
     *
     * <code>
     * $str = BeyondAuth::getRandomStr();
     * echo $str;
     * </code>
     *
     * @param $length integer
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    public function getRandomStr($length = 42)
    {
        /*
         * Use OpenSSL (if available)
         */
        if (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes($length * 2);
            if ($bytes === false) {
                throw new \RuntimeException('Unable to generate a random string');
            }

            return substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $length);
        }

        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    /**
     * This function implements the algorithm outlined
     * in RFC 6238 for Time-Based One-Time Passwords.
     *
     * @link http://tools.ietf.org/html/rfc6238
     *
     * @param string $key    the string to use for the HMAC key
     * @param mixed  $time   a value that reflects a time (unix
     *                       time in the example)
     * @param int    $digits the desired length of the OTP
     * @param string $crypto the desired HMAC crypto algorithm
     *
     * @return string the generated OTP
     */
    public function getRfc($key, $time, $digits = 8, $crypto = 'sha256')
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
     * Replace all http:// dan www pada URL.
     *
     * <code>
     * $str = BeyondAuth::replaceHttp('https://ngakost.net');
     * echo $str;
     * </code>
     *
     * @param string $value nama guard yang dipergunakan.
     *
     * @return string
     */
    public function replaceHttp($value)
    {
        preg_match("/^(https?:\/\/)?([^\/]+)/i", $value, $matches);
        $newstr = str_replace("www.", '', $matches[2]);
        return $newstr;
    }

    /**
     * Get user data (Must login).
     *
     * <code>
     * $users = BeyondAuth::auth('web_admins')->username
     * </code>
     *
     * @param string $guard nama guard yang dipergunakan.
     *
     * @return string
     */
    public function auth($guard = null)
    {
        $isLogged = Auth::guard($guard)->check();
        if ($isLogged) {
            return Auth::guard($guard)->user();
        } else {
            return false;
        }
    }

    /**
     * Get user role (Must login).
     *
     * <code>
     * $userRole = BeyondAuth::getUserRole('web_admins')->coded;
     * echo $userRole;
     * </code>
     *
     * @param string $guard nama guard yang dipergunakan.
     *
     * @return boolean | Array
     */
    public function getUserRole($guard = null)
    {
        $isLogged = Auth::guard($guard)->check();

        if ($isLogged) {
            $role = $this->auth($guard)->roles->first();
            if (!is_null($role)) {
                return $role;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get role permission (Must login).
     *
     * <code>
     * $getRolePermission = BeyondAuth::getRolePermission();
     * echo $getRolePermission;
     * </code>
     *
     * @return boolean | Array
     */
    public function getCache($key)
    {
        return Cache::store('file')->get($key, 0);
    }

    /**
     * Get role permission cache (Must login).
     *
     * <code>
     * $getPermissionCache = BeyondAuth::getHasCache();
     * echo $getPermissionCache;
     * </code>
     *
     * @return boolean | Array
     */
    public function getHasCache($key)
    {
        return Cache::store('file')->has($key);
    }

    /**
     * Put role cache (Must login).
     *
     * <code>
     * $getRolePermission = BeyondAuth::getRolePermission();
     * echo $getRolePermission;
     * </code>
     *
     * @return boolean | Array
     */

    public function putCache($key, $value)
    {
        return Cache::store('file')->put($key, $value, 10);
    }

    /**
     * Get role (Must login).
     *
     * <code>
     * $getRolePermission = BeyondAuth::getRolePermission();
     * echo $getRolePermission;
     * </code>
     *
     * @return boolean | Array
     */
    public function getRolePermission()
    {
        $usergroup = $this->getUserRole('web_admins');

        if ($usergroup) {
            $value = $usergroup->permissions()->get();
            return $value;
        } else {
            return false;
        }
    }

    /**
     * Check User can execute method.
     *
     * <code>
     *    if(!BeyondAuth::can('usergroup.view')){
     *        return Redirect::to('admin');
     *    }
     * </code>
     *
     * @param string $permission name_permission yang akan di cek
     *
     * @return boolean
     */
    public function can($permission)
    {
        $perms = $this->getRolePermission();
        if ($perms) {
            foreach ($perms as $perm) {
                if ($perm->name_permission == $permission) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Get User was auth
     *
     * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser()
     *
     * @return \Pribumi\BeyondAuth\AuthManager
     */
    public function getUserAuth()
    {
        return $this->app['beyondauth.auth']->user();
    }

    /**
     * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser()
     *
     * @return \Pribumi\BeyondAuth\AuthManager
     */
    public function getAuthManager()
    {
        return $this->app['beyondauth.manager'];
    }

    /**
     * Calling `ApiKeys Repository` From This Class.
     *
     * <code>
     * $data = BeyondAuth::usersactivations()->get();
     * echo json_encode($data);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser()
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentApiKeyUsersRepository
     */
    public function usersactivations()
    {
        return $this->app['beyondauth.usersactivations'];
    }

    /**
     * Calling `Company Repository` From This Class.
     *
     * <code>
     * $data = BeyondAuth::company()->get();
     * echo json_encode($data);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser()
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentCompanyRepository
     */
    public function company()
    {
        return $this->app['beyondauth.company'];
    }

    /**
     * Calling `ApiKeys Repository` From This Class.
     *
     * <code>
     * $data = BeyondAuth::apikeyusers()->get();
     * echo json_encode($data);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser()
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentApiKeyUsersRepository
     */
    public function apikeyusers()
    {
        return $this->app['beyondauth.apikeyuser'];
    }

    /**
     * Calling `User Repository` From This Class.
     *
     * BeyondAuth::users()->findByEmail('xxxxx@gmail.com');
     *
     * <code>
     * $uservalues = \BeyondAuth::users()->find(1)->uservalues()->get();
     * echo json_encode($uservalues);
     * </code>
     *
     * <code>
     * $roles = \BeyondAuth::users()->find(1)->roles()->get();
     * echo json_encode($roles);
     * </code>
     *
     *
     * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser()
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserRepository
     */
    public function users()
    {
        return $this->app['beyondauth.user'];
    }

    /**
     * Calling `UserPermission Repository` From This Class.
     *
     * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser()
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserPermissionRepository
     */
    public function userpermissions()
    {
        return $this->app['beyondauth.user_permissions'];
    }

    /**
     * Calling `UserGroup Repository` From This Class.
     *
     * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser()
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserGroupRepository
     */
    public function usergroup()
    {
        return $this->app['beyondauth.usergroup'];
    }

    /**
     * Calling `Periode Repository` From This Class.
     *
     * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser()
     * @return \Pribumi\BeyondAuth\Repositories\EloquentPeriodeRepository
     */
    public function periodes()
    {
        return $this->app['beyondauth.periode'];
    }

    /**
     * Calling `UserFieldGroup Repository` From This Class.
     *
     * <code>
     * $data = BeyondAuth::userfieldsGroups()->get();
     * echo json_encode($data);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser()
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserFieldGroupRepository
     */
    public function userfieldsGroups()
    {
        return $this->app['beyondauth.usersfields_groups'];
    }

    /**
     * Calling `UserField Repository` From This Class.
     *
     * <code>
     * $data = BeyondAuth::usersfields()->with('fieldtypes')->with('userfieldgroups')->get();
     * echo json_encode($data);
     * </code>
     *
     * OR
     *
     * <code>
     * $usersfields = BeyondAuth::usersfields()
     * ->with('fieldtypes')
     * ->with('userfieldgroups')
     * ->with('domains')
     * ->where('is_active', 1)
     * ->where('show_in_signup', 1)
     * ->orderBy('field_order', 'desc')
     * ->get();
     * foreach($usersfields as $row){
     * if(count($row->domains) > 0){
     * echo $row->field_name . '-HANYA UNTUK-' . '<br/>';
     * }else{
     * echo $row->field_name.'<br/>';
     * }
     * echo $row->field_name.'<br/>';
     * echo $row->fieldtypes['field_name'].'<br/>';
     * echo $row->userfieldgroups['group_name'].'<br/>';
     * }
     * </code>
     * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser()
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserFieldGroupRepository
     */
    public function usersfields()
    {
        return $this->app['beyondauth.usersfields'];
    }

    /**
     * Calling `UserMenus Repository` From This Class.
     *
     * <code>
     * $data = BeyondAuth::menus()->get();
     * echo json_encode($data);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser()
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserMenuRepository
     */
    public function menus()
    {
        return $this->app['beyondauth.users_menus'];
    }

    /**
     * Calling `Field Types Repository` From This Class.
     *
     * <code>
     * $data = BeyondAuth::fieldtypes()->get();
     * echo json_encode($data);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser()
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentFieldTypesRepository
     */
    public function fieldtypes()
    {
        return $this->app['beyondauth.fieldtypes'];
    }

    /**
     * Calling `UserFieldValue Repository` From This Class.
     *
     * <code>
     * $data = BeyondAuth::usersfieldsValue()->get();
     * echo json_encode($data);
     * </code>
     *
     * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser()
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserFieldValueRepository
     */
    public function usersfieldsValue()
    {
        return $this->app['beyondauth.usersfields_value'];
    }

    /**
     * `create()` For Domain Model.
     *
     * @param array $data
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentDomainRepository
     */
    public function createDomain($data)
    {
        if (!is_null($this->getDomain())) {
            return $this->getDomain()->create($data);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * `create()` For UserGroup Model
     *
     * @param array $data
     *
     * @throws MethodNotExist
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserGroupRepository
     */
    public function createUserGroup($data)
    {
        if (!is_null($this->usergroup())) {
            return $this->usergroup()->create($data);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * `create()` For UserPermission Model
     *
     * @param array $data
     *
     * @throws MethodNotExist
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserPermissionRepository
     */
    public function createUserPermission($data)
    {
        if (!is_null($this->userpermissions())) {
            return $this->userpermissions()->create($data);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * `registerUser()` For User Model
     *
     * @param array $data
     *
     * @throws MethodNotExist
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserRepository
     */
    public function registerUser($data, $profileField = array(), $callback)
    {
        if ($callback !== null && !$callback instanceof Closure && !is_bool($callback)) {
            throw new InvalidArgumentException('You must provide a closure or a boolean.');
        }

        if (!is_null($this->users())) {
            return $this->users()->registerUser($data, $profileField, $callback);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * `create()` For Periode Model
     *
     * @param array $data
     *
     * @throws MethodNotExist
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentPeriodeRepository
     */
    public function createPeriode($data)
    {
        if (!is_null($this->periodes())) {
            return $this->periodes()->create($data);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * `create()` For UserFieldGroup Model
     *
     * @param array $data
     *
     * @throws MethodNotExist
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserFieldGroupRepository
     */
    public function createUserFieldGroup($data)
    {
        if (!is_null($this->userfieldsGroups())) {
            return $this->userfieldsGroups()->create($data);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * `create()` For UserField Model
     *
     * @param array $data
     *
     * @throws MethodNotExist
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserFieldRepository
     */
    public function createUserField($data)
    {
        if (!is_null($this->usersfields())) {
            return $this->usersfields()->create($data);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * `findByWhere()` For UserPermission Model
     *
     * @param string $field
     * @param string $value
     *
     * @throws MethodNotExist
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserPermissionRepository
     */
    public function findUserPermissionsBy($field, $value)
    {
        if (!is_null($this->userpermissions())) {
            return $this->userpermissions()->findByWhere($field, $value);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * `findByWhere()` For UsersFieldsValue Model
     *
     * @param string $field
     * @param string $value
     *
     * @throws MethodNotExist
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserFieldValueRepository
     */
    public function findUsersFieldsValueBy($field, $value)
    {
        if (!is_null($this->usersfieldsValue())) {
            return $this->usersfieldsValue()->findByWhere($field, $value);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * `findByWhere()` For Domain Model
     *
     * @param string $field
     * @param string $value
     *
     * @throws MethodNotExist
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserRoleRepository
     */
    public function findUserGroupBy($field, $value)
    {
        if (!is_null($this->usergroup())) {
            return $this->usergroup()->findByWhere($field, $value);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * `findByWhere()` Untuk Periode Model
     *
     * @param string $field
     * @param string $value
     *
     * @throws MethodNotExist
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentPeriodeRepository
     */
    public function findPeriodeBy($field, $value)
    {
        if (!is_null($this->periodes())) {
            return $this->periodes()->findByWhere($field, $value);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * `findByWhere()` Untuk UserFieldGroup Model
     *
     * @param string $field
     * @param string $value
     *
     * @throws MethodNotExist
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserFieldGroupRepository
     */
    public function findUserFieldGroupBy($field, $value)
    {
        if (!is_null($this->userfieldsGroups())) {
            return $this->userfieldsGroups()->findByWhere($field, $value);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * `findByWhere()` Untuk UserField Model
     *
     * @param string $field
     * @param string $value
     *
     * @throws MethodNotExist
     *
     * @return \Pribumi\BeyondAuth\Repositories\EloquentUserFieldRepository
     */
    public function findUserFieldBy($field, $value)
    {
        if (!is_null($this->usersfields())) {
            return $this->usersfields()->findByWhere($field, $value);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * Build Main Menu Aplikasi
     *
     * <code>
     * $data = BeyondAuth::getMenus();
     * echo json_encode($str);
     * </code>
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    public function getMenus()
    {
        if (!is_null($this->menus())) {
            return $this->menus()->getMenus();
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * Build Main Menu Untuk Blade Template
     *
     * <code>
     * $data = BeyondAuth::getSidebar(1,1,1);
     * echo json_encode($str);
     * </code>
     *
     * @param $user_groups integer Nilai Dari Grup User
     * @param $id_menu integer Nilai Dari Menu
     * @param $active integer Nilai Apakah Menu Tsb Aktif?
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    public function getSidebar($user_groups, $id_menu = 1, $active = 1)
    {
        if (!is_null($this->menus())) {
            return $this->menus()->getSidebar($user_groups, $id_menu, $active);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * Build Main Menu Aplikasi
     *
     * <code>
     * $data = BeyondAuth::getMenusBy(1,1);
     * echo json_encode($str);
     * </code>
     *
     * @param $user_groups integer Nilai Dari Grup User
     * @param $id_menu integer Nilai Dari Menu
     * @param $active integer Nilai Apakah Menu Tsb Aktif?
     *
     * @throws \RuntimeException
    &
     * @return string
     */
    public function getMenusBy($user_groups = null, $id_menu = 1, $active = 1)
    {
        if (!is_null($this->menus())) {
            return $this->menus()->getMenusBy($user_groups, $id_menu, $active);
        } else {
            return new MethodNotExist();
        }
    }

    /**
     * Dapatkan Custom Fields dari database
     *
     * <code>
     * $fields = \BeyondAuth::getCustomUserFields('member', 0, 1, 1, 0);
     * echo json_encode($fields);
     * </code>
     *
     * @param string $roleName dapatkan custom berdasarkan role
     * @param string $domainName dapatkan custom fields yang terdapat pada nama domain saja
     * @param int $group_field_id group custom field dari group field apa? personal, payment, etc...
     * @param int $show_in_signup display on signup perlihatkan field yang hanya untuk signup saja?
     * @param int $is_active perlihatkan fields yang aktif?
     * @param int $admin_use_only perlihat fields yang untuk admin saja?
     *
     * @return array
     */
    public function getCustomUserFields($roleName = '', $group_field_id = 0,
        $show_in_signup = 1, $is_active = 1,
        $admin_use_only = 0) {
        if (!is_null($this->usersfields())) {
            return $this->usersfields()->getCustomFields($roleName,
                $group_field_id, $show_in_signup,
                $is_active, $admin_use_only);
        } else {
            return new MethodNotExist();
        }
    }

}
