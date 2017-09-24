<?php

namespace Pribumi\BeyondAuth\Repositories;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use Pribumi\BeyondAuth\Contracts\User as UserRepository;
use Pribumi\BeyondAuth\Models\User;
use Pribumi\BeyondAuth\Models\UserActivation;
use Pribumi\BeyondAuth\Models\UserField;
use Pribumi\BeyondAuth\Models\UserFieldValue;

/**
 * Class EloquentUserFieldRepository
 *
 * Ini Class Encapsulasi agar model dapat dipanggil dari luar package
 * Note : Tambahkan fungsi disini...
 *
 *
 * Langkah Ke-4 :
 * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser
 *
 *
 * @package Pribumi\BeyondAuth\Repositories
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 * @link       http://pribumitech.com
 */
class EloquentUserRepository extends AbstractEloquentRepository implements UserRepository
{
    protected $model;

    protected $userField;

    protected $userActivation;

    protected $userFieldValue;

    /**
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Pribumi\BeyondAuth\Models\User $model
     * @param \Pribumi\BeyondAuth\Models\UserField $userField
     * @param \Pribumi\BeyondAuth\Models\UserActivation $userActivation
     * @param \Pribumi\BeyondAuth\Models\UserFieldValue $userFieldValue
     */
    public function __construct(Application $app, User $model, UserField $userField,
        UserActivation $userActivation,
        UserFieldValue $userFieldValue) {

        parent::__construct($app, $model, $userField, $userActivation);
        $this->model          = $model;
        $this->userField      = $userField;
        $this->userActivation = $userActivation;
        $this->userFieldValue = $userFieldValue;
    }

    /**
     * Dynamic copy `method-method` pada `Model` yang dituju,
     * tujuannya agar class ini tidak menambahkan secara
     * terus menerus `method-method` yang terdapat pada `Model`.
     *
     * method ini tidak perlu dipanggil dimanapun, karena otomatis
     * saat class ini terpanggil method jalan dengan sendiri-nya
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (is_callable(array($this->model, $method))) {
            return call_user_func_array([$this->model, $method], $parameters);
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->model->getPrimary();
    }

    public function getName()
    {
        return $this->model->getName();
    }

    public function getEmail()
    {
        return $this->model->getEmail();
    }

    public function getDefaultRoleName()
    {
        return $this->model->getDefaultRoleName();
    }

    /**
     * Register new user as member
     */
    public function registerUser($data, $callback)
    {

        if ($callback !== null && !$callback instanceof Closure && !is_bool($callback)) {
            throw new InvalidArgumentException('You must provide a closure or a boolean.');
        }

        $member             = $this->model;
        $member->username   = $data['name'];
        $member->email      = $data['email'];
        $_passwd            = Hash::make($data['password'], ['cost' => 10]);
        $member->password   = $_passwd;
        $member->is_builtin = 0;

        if ($callback === false) {
            $member->verified  = 0;
            $member->is_active = 0;
        } else {
            $member->verified  = 1;
            $member->is_active = 1;
        }

        $this->model->save();

        $id = $this->getId();

        // ==== Dapatkan id dari member yang ter-registrasi
        $lastMember = $member->{$id};

        // ==== Dapatkan data custom field dan simpan ke database
        foreach ($data['custom_field'] as $id => $row) {
            foreach (array_keys($row) as $fieldname) {
                $idFields = UserField::where('field_name', $fieldname)->first();
                if ($idFields !== null) {
                    $customField = new UserFieldValue();
                    //$customField                   = new $this->userFieldValue;
                    $customField->user_id          = $lastMember;
                    $customField->custom_fields_id = $idFields->id_custom_fields;
                    $customField->field_value      = $row[$fieldname];
                    $customField->save();
                }
            }
        }

        $getRolename = $this->getDefaultRoleName();

        // ==== Attach member to default role
        $member->attachRole($getRolename);

        if ($callback === false) {
            $act                     = $this->userActivation;
            $this->confirmation_code = $act->generateToken();
            $act->activation_code    = $this->confirmation_code;
            $act->save();
            $member->attachActivation($act->activation_code);
        }

        return $member;

    }
}
