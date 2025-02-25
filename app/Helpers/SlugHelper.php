<?php

if (!function_exists('str_slug')) {

    /**
     * description
     *
     * @param
     * @return
     */
   function str_slug($string)
    {
        $string = mb_strtolower($string);
        $string = str_replace('?', '', $string);
        $string = str_replace('%', '', $string);
        $string = str_replace('(', '', $string);
        $string = str_replace(')', '', $string);
        $string = preg_replace('/\s+/u', '-', trim($string));
        return $string;
    }
}
