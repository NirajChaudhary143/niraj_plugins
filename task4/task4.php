<?php

/**
 * Plugin Name: Task 4
 * Author: Niraj Chaudhary
 * Description: This is task 4 Plugin
 */

if (!defined('ABSPATH')) {

    header("Location: /ThemeGrill/task3/");
}


function show_Menu_fun()
{
    add_menu_page('Send Mail', 'Send Mail', 'manage_options', 'send-mail', "show_menu", 'dashicons-email', 6);
    add_submenu_page('send-mail', 'Send Mail', 'Send Mail', 'manage_options', 'send-mail', 'show_menu');
}
function show_menu()
{
    include "send-email-form.php";
}
add_action('admin_menu', 'show_Menu_fun');
