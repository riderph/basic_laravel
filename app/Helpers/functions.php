<?php

/**
 * This is the common function used at all request
 * This file will define in: Providers/HelperServiceProvider
 */

if (!function_exists('trim_without_array')) {

    /**
     * Trim without value is array
     *
     * @param array $values  Array will be trim
     * @param array $excepts Array except
     *
     * @return string
     */
    function trim_without_array($values, $excepts = [])
    {
        array_walk($values, function (&$value, $key) use ($excepts) {
            if (!is_array($value) && !in_array($key, $excepts)) {
                $value = trim($value);
            }
        });
        return  $values;
    }
}
