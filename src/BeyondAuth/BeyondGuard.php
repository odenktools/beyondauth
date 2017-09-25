<?php

namespace Pribumi\BeyondAuth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard as GuardContract;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

/**
 * @package Pribumi\BeyondAuth
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 * @link       http://pribumitech.com
 */
class BeyondGuard implements GuardContract
{
    use GuardHelpers;

    /**
     * The JWT instance.
     *
     * @var \Pribumi\BeyondAuth\BeyondAuth
     */
    protected $beyondAuth;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Instantiate the class.
     *
     * @param  \Tymon\JWTAuth\JWT  $jwt
     * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
     * @param  \Illuminate\Http\Request  $request
     *
     * @return void
     */
    public function __construct(BeyondAuth $beyondAuth, UserProvider $provider, Request $request)
    {
        $this->beyondAuth = $beyondAuth;
        $this->provider   = $provider;
        $this->request    = $request;
    }

    /**
     * Determine if the user matches the credentials.
     *
     * @param  mixed  $user
     * @param  array  $credentials
     *
     * @return bool
     */
    protected function hasValidCredentials($user, $credentials)
    {
        return $user !== null && $this->provider->validateCredentials($user, $credentials);
    }
    
    /**
     * Get the user provider used by the guard.
     *
     * @return \Illuminate\Contracts\Auth\UserProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set the user provider used by the guard.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
     *
     * @return $this
     */
    public function setProvider(UserProvider $provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param  array $credentials
     * @param  bool $remember
     * @param  bool $login
     * @return bool
     */
    public function attempt(array $credentials = [], $remember = false, $login = true)
    {
        //$this->fireAttemptEvent($credentials, $remember, $login);

        $this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);

        if (!$this->hasValidCredentials($user, $credentials)) {
            return false;
        } else {
            /* $user is userModels */
            if (!$user->isVerified()) {
                return false;
            }
            if (!$user->isActivated()) {
                return false;
            }

            if ($user->hasAnyRole()) {
                $isPurchase = $user->isPurchaseable();
                if ($isPurchase) {
                    if ($user->expire_date === null) {
                        $calc              = $user->calculateDays($user->getAuthIdentifier());
                        $user->expire_date = $calc;
                        $user->last_login  = date('Y-m-d H:i:s');
                        $user->updated_at  = date('Y-m-d H:i:s');
                        $user->save();
                    } else {
                        if ($user->isExpired($user->getAuthIdentifier())) {
                            return false;
                        } else {
                            $user->last_login = date('Y-m-d H:i:s');
                            $user->updated_at = date('Y-m-d H:i:s');
                            $user->save();
                        }
                    }
                } else {
                    $user->last_login = date('Y-m-d H:i:s');
                    $user->updated_at = date('Y-m-d H:i:s');
                    $user->save();
                }
            } else {
                throw new \RuntimeException('User not has any roles, please setup user roles.');
            }
            return $login ? $this->login($user) : true;
        }
        return false;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        return (bool) $this->attempt($credentials, false);
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if ($this->user !== null) {
            return $this->user;
        }
    }

}
