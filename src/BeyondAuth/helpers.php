<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('beyonduser')) {

    /**
     * Get upload folder.
     *
     * @param string $guard
     *
     * @return string
     */
    function beyonduser($guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return Auth::guard($guard)->user();
        }
        return null;
    }
}
