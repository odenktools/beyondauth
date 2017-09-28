<?php

namespace Pribumi\BeyondAuth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Laravel Facades.
 *
 * @version    1.0.0
 *
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 */
class BeyondAuth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'beyondauth.facade';
    }
}
