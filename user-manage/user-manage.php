<?php

/**
 * Plugin Name: Manage Employee
 * Description: You can manage your employees
 * Version: 1.0.0
 * Text Domain: user-manage
 * Author: Niraj Chaudhary
 * Author URI: #
 * 
 * @package userManage/
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Main UserManage Class.
 * 
 * @class UserManage
 * 
 */
final class UserManage
{
    public function __construct()
    {
        $this->includes();
        $this->init_hooks();
    }
    /**
     * Hooks and filter are initialized
     */
    private function init_hooks()
    {
        register_activation_hook(__FILE__, array($this, 'um_install'));
        register_deactivation_hook(__FILE__, array($this, 'um_deactivate'));
    }
    /**
     * function um_install create a database name wp_emp
     * 
     * @param $wpdb,$table_prefix are global variables
     */
    public function um_install()
    {
        global $wpdb, $table_prefix;
        $wp_emp = $table_prefix . 'emp';
        $query = "CREATE TABLE IF NOT EXISTS `$wp_emp` (`id` INT(255) NOT NULL AUTO_INCREMENT , `fullname` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `contact_number` VARCHAR(255) NOT NULL , `gender` TEXT NOT NULL , `user_bio` VARCHAR(255) NOT NULL , `employee_status` VARCHAR(255) NOT NULL , `picture` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`))";
        $wpdb->query($query);
    }
    /**
     * function um_uninstall drop the rows a database name wp_emp
     * 
     * @param $wpdb,$table_prefix are global variables
     */
    public function um_deactivate()
    {
        global $wpdb, $table_prefix;
        $wp_emp = $table_prefix . 'emp';
        $query = "TRUNCATE TABLE `$wp_emp`";
        $wpdb->query($query);
    }
    public function includes()
    {
        include_once __DIR__ . "/includes/class-um-form-render.php";
    }
}
new UserManage();
