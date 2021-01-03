<?php

/**
 * Gets the Mailchimp for WP options from the database
 * Uses default values to prevent undefined index notices.
 *
 * @since 1.0
 * @access public
 * @static array $options
 * @return array
 */
function nekomc_get_options()
{
    $defaults = require NEKOMC_PLUGIN_DIR . 'config/default-settings.php';
    $options  = (array) get_option('nekomc', array());
    $options  = array_merge($defaults, $options);

    /**
     * Filters the Mailchimp for WordPress settings (general).
     *
     * @param array $options
     */
    return apply_filters('nekomc_settings', $options);
}


/**
 * @return array
 */
function nekomc_get_settings()
{
    return nekomc_get_options();
}


/**
 * @return string
 */
function nekomc_get_api_key()
{
    // try to get from constant
    if (defined('NEKOMC_API_KEY') && constant('NEKOMC_API_KEY') !== '') {
        return NEKOMC_API_KEY;
    }

    // get from options
    $opts = nekomc_get_options();
    return $opts['api_key'];
}

/**
 * This will replace the first half of a string with "*" characters.
 *
 * @param string $string
 * @return string
 */
function nekomc_obfuscate_string($string)
{
    $length            = strlen($string);
    $obfuscated_length = ceil($length / 2);
    $string            = str_repeat('*', $obfuscated_length) . substr($string, $obfuscated_length);
    return $string;
}
