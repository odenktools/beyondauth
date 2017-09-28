<?php

namespace Pribumi\BeyondAuth\Repositories;

use Pribumi\BeyondAuth\Models\UserMenus;
use Illuminate\Contracts\Foundation\Application;
use Pribumi\BeyondAuth\Contracts\UserMenuInterface as UserMenuRepository;

/**
 * Class EloquentUserMenuRepository.
 *
 * Ini Class Encapsulasi agar model dapat dipanggil dari luar package
 * Note : Tambahkan fungsi disini...
 *
 *
 * Langkah Ke-4 :
 *
 * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerCustomUser
 *
 * @version    1.0.0
 *
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 *
 * @link       http://pribumitech.com
 */
class EloquentUserMenuRepository extends AbstractEloquentRepository implements UserMenuRepository
{
    /**
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Pribumi\BeyondAuth\Models\UserMenus $model
     */
    public function __construct(Application $app, UserMenus $model)
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
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (is_callable([$this->model, $method])) {
            return call_user_func_array([$this->model, $method], $parameters);
        }

        return false;
    }
}
