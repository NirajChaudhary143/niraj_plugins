<?php

/**
 * Plugin Name: User Registration Form Custom
 * Description: Register a user using Ajax in response show success message.
 * Author Name: Niraj Chaudhary
 * Author URI: #
 * Text Domain: urfc_
 * Version: 1.0.0
 */

class urcf_UserRegistration
{

    function __construct()
    {
        include "function.php";
        $userObj = new UserRegister();
        add_action('admin_menu', array($this, 'urfc_registration_form'));
        add_action('wp_enqueue_scripts', array($this, 'urfc_load_scripts_fn'));
        add_action('wp_ajax_urfc_register_user', array($userObj, 'urfc_register_user_fn'));
    }
    function urfc_load_scripts_fn()
    {
        wp_enqueue_script('my-jquery-handler', plugins_url('/scripts/main.js', __FILE__), array('jquery'), '1.0', true);
        error_log(print_r(plugins_url('/scripts/main.js', __FILE__), true));
    }
    public function urfc_registration_form()
    {
        add_menu_page('Registration', 'My User Registration', 'manage_options', 'urfc-user-register', array($this, 'urfc_user_register_form'));
    }

    public function urfc_user_register_form()
    {
        include "form.php";
    }
}

new urcf_UserRegistration();
