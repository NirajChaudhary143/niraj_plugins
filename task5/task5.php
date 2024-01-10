<?php

/**
 * Plugin Name: Test5
 * Description: Shortcode Testing
 * Version: 1.0.0
 * Author: Niraj Chaudhary
 * Author URI: #
 * Text Domain: add_role
 * */
defined('ABSPATH') || exit;
class UserData
{
    function __construct()
    {
        add_shortcode('add_role_user_registration', array($this, 'add_role_template_form'));
    }

    function add_role_template_form($atts)
    {
        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        $atts = shortcode_atts(array('type' => 'redirect_after_registration'), $atts);
        ob_start();
        include $atts['type'] . '.php';
        $html = ob_get_clean();
        return $html;
    }
}
new UserData();
