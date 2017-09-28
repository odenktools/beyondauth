<?php

namespace Pribumi\BeyondAuth\Contracts;

/**
 * Langkah Ke-1 :.
 *
 * Interface FactoryInterface
 *
 * Langkah Ke-2 :
 * @see Pribumi\BeyondAuth\Repositories\AbstractEloquentRepository
 *
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 */
interface FactoryInterface
{
    /**
     * Get an provider implementation.
     *
     * @param  string  $driver
     * @return \Pribumi\BeyondAuth\Contracts\ProviderInterface
     */
    public function driver($driver = null);
}
