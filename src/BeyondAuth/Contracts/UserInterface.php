<?php

namespace Pribumi\BeyondAuth\Contracts;

/**
 * Langkah Ke-1 :.
 *
 * Interface UserGroupInterface
 *
 * Langkah Ke-2 :
 *
 * @see Pribumi\BeyondAuth\Repositories\AbstractEloquentRepository
 *
 * @version    1.0.0
 *
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 */
interface UserInterface
{
    /**
     * Get the unique identifier for the user.
     *
     * @return string
     */
    public function getId();

    /**
     * Get the full name of the user.
     *
     * @return string
     */
    public function getName();

    /**
     * Get the e-mail address of the user.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Get default role name.
     *
     * @return string
     */
    public function getDefaultRoleName();
}
