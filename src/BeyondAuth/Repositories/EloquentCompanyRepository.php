<?php

namespace Pribumi\BeyondAuth\Repositories;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use Pribumi\BeyondAuth\Contracts\CompanyRepository;
use Pribumi\BeyondAuth\Models\Company;
use Pribumi\BeyondAuth\Models\UserActivation;

/**
 * Class EloquentCompanyRepository
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
class EloquentCompanyRepository extends AbstractEloquentRepository implements CompanyRepository
{
    protected $model;

    protected $userActivation;

    /**
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Pribumi\BeyondAuth\Models\Company $model
     * @param \Pribumi\BeyondAuth\Models\UserActivation $userActivation
     */
    public function __construct(Application $app, Company $model, UserActivation $userActivation)
    {

        parent::__construct($app, $model, $userActivation);
        $this->model          = $model;
        $this->userActivation = $userActivation;
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

    /**
     * Register new company as member
     */
    public function registerCompany($data, $callback)
    {

        if ($callback !== null && !$callback instanceof Closure && !is_bool($callback)) {
            throw new InvalidArgumentException('You must provide a closure or a boolean.');
        }

        $member           = $this->model;
        $member->name     = $data['name'];
        $member->email    = $data['email'];
        $_passwd          = Hash::make($data['password'], ['cost' => 10]);
        $member->password = $_passwd;

        if ($callback === false) {
            $member->verified  = 0;
            $member->is_active = 0;
        } else {
            $member->verified  = 1;
            $member->is_active = 1;
        }

        $this->model->save();

        // ==== Dapatkan id dari member yang ter-registrasi
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
