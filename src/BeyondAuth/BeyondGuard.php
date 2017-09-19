<?php

namespace Pribumi\BeyondAuth;

use Illuminate\Auth\Guard as AuthGuard;
use Illuminate\Contracts\Auth\Guard as GuardContract;

/**
 * @package Pribumi\BeyondAuth
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 * @link       http://pribumitech.com
 */
class BeyondGuard extends AuthGuard implements GuardContract
{
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
        $this->fireAttemptEvent($credentials, $remember, $login);

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

            if ($login) {
                $this->login($user, $remember);
            }

        }
        return false;
    }

}
