<?php

namespace Pribumi\BeyondAuth\Contracts;

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
