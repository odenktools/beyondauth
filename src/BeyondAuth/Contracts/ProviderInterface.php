<?php

namespace Pribumi\BeyondAuth\Contracts;

/**
 * Langkah Ke-1 :.
 *
 * Interface ProviderInterface.
 *
 * Langkah Ke-2 :
 * @see Pribumi\BeyondAuth\Repositories\AbstractEloquentRepository
 *
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 */
interface ProviderInterface
{
    /**
     * Redirect the user to the authentication page for the provider.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect();

    /**
     * Get the User instance for the authenticated user.
     *
     * @return \Pribumi\BeyondAuth\Contracts\UserInterface
     */
    public function user();

    /**
     * Get the UserInterface instance for the authenticated user.
     *
     * @return \Pribumi\BeyondAuth\Contracts\Member
     */
    public function member();

    /**
     * Get the UserInterface instance for the authenticated user.
     *
     * @return \Pribumi\BeyondAuth\Contracts\Customer
     */
    public function customer();

}
