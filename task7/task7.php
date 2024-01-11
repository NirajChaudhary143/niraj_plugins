<?php

/**
 * Plugin Name: Task 7
 * Author Name: Niraj Chaudhary
 * Author UI: #
 * Description: We will study here about option API and setting API
 * Text Domain: os_api
 */
require "addMenu.php";
require "form.php";

class MenuSubmenu
{
    public function __construct()
    {
        $menuObj = new AddMenu();
        $movieForm = new movieForm();
        add_action('admin_menu', array($menuObj, 's_menuadd__movie'));
        add_action('admin_init', array($movieForm, 's_menu_movie_init'));
    }
}

new MenuSubmenu();
