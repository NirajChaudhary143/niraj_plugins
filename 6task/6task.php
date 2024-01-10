<?php

/**
 * Plugin Name: Task 6
 * Description: Create a plugin that registers a Top level menu called “Movie”. It should have a submenu called “Dashboard” and “Settings”. Simply just register the menu for now. No need to add any settings inside. 
 * Author: Niraj Chaudhary
 * Author URI: #
 * Text Domain: s_menu
 * Version: 1.0.0
 */

class MenuSubmenu
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 's_menu_movie'));
    }

    public function s_menu_movie()
    {
        add_menu_page(
            'Movie',
            'Movie',
            'manage_options',
            'movie',
            array($this, 's_movie_movie_fn'),
            'dashicons-format-video',
            7
        );

        add_submenu_page('movie', 'Dashboard', 'Dashboard', 'manage_options', 'movie');
        add_submenu_page('movie', 'Settings', 'Settings', 'manage_options', 'movie-settings', array($this, 's_movie_settings_fn'));
    }

    public function s_movie_movie_fn()
    {
    }
    public function s_movie_settings_fn()
    {
    }
}

new MenuSubmenu();
