<?php

use App\Setting;

if (!function_exists('setting')) {

    /**
     * description
     *
     * @param $name
     * @param null $default
     * @return string
     */
    function setting($name,$default=null)
    {
        return Setting::getByName($name,$default);
    }
}
