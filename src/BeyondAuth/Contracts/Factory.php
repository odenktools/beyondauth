<?php

namespace Pribumi\BeyondAuth\Contracts;

interface Factory
{
    /**
     * Get an OAuth provider implementation.
     *
     * @param  string  $driver
     * @return \Pribumi\BeyondAuth\Contracts\Provider
     */
    public function driver($driver = null);
}