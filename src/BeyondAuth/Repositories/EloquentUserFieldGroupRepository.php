<?php

namespace Pribumi\BeyondAuth\Repositories;

use Illuminate\Contracts\Foundation\Application;
use Pribumi\BeyondAuth\Contracts\UserFieldGroupRepository;
use Pribumi\BeyondAuth\Models\UserFieldGroup;

/**
 * Class EloquentUserFieldGroupRepository
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
class EloquentUserFieldGroupRepository extends AbstractEloquentRepository implements UserFieldGroupRepository
{
    /**
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Pribumi\BeyondAuth\Models\UserFieldGroup $model
     */
    public function __construct(Application $app, UserFieldGroup $model)
    {
        parent::__construct($app, $model);
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
}
