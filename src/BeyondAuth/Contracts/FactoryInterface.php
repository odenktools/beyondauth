<?php

namespace Pribumi\BeyondAuth\Contracts;

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
