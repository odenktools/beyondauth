<?php

namespace Pribumi\BeyondAuth\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class AbstractEloquentRepository.
 *
 * Langkah Ke-3 :
 *
 * @see \Pribumi\BeyondAuth\Repositories\EloquentDomainRepository
 *
 * @version    1.0.0
 *
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 *
 * @link       http://pribumitech.com
 */
abstract class AbstractEloquentRepository
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Model|\Illuminate\Database\Eloquent\Builder
     */
    protected $model;

    /**
     * @param Application $app
     * @param Model $model
     */
    public function __construct(Application $app, Model $model)
    {
        $this->app = $app;
        $this->model = $model;
    }
}
