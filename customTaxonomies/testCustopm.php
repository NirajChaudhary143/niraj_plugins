<?php

/**
 *Plugin Name: Custom Taxonomies 
 * Version: 1.0
 * Description: Taxonomies 
 * Author: Samyog Subedi
 * Text Domain : ct_
 */

class MyFruits
{
    public function __construct()
    {
        add_action('init', array($this, 'ct_register_fruit'));
    }
    public function ct_register_fruit()
    {
        $labels = array(
            'name' => ('Fruits'),
            'add_new' => ('Add New Fruits'),
            'new_item_name' => ('New Fruit Name'),
            'update_item'  => ('Update Fruit'),
            'edit_item'  => ('Edit Fruit'),
            'menu_name' => ('Fruits'),
            'search_items' => ('Search Fruits'),
            'all_items' => ('All Fruits'),
            'add_new_item' => ('Add New Fruits'),



        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'taxonomies' => array('category'),
            'show_ui' => true,

        );

        register_post_type('fruits', $args);
        register_taxonomy(
            'fruits_tag',
            'fruits',
            array(
                'label' => ('Fruits Tag'),
                'hierarchical' => true,
                'show_admin_column' => true,
            )
        );
    }
}
new MyFruits();
