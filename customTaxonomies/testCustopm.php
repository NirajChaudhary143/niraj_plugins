<?php

/**
 * Plugin Name: Custom Taxonomies
 * Description: Create a Custom Taxonomies called Fruits with where we can add terms like Banana, Apple, Orange etc. 
 * 
 */
class TestCustom
{
    function cts_movie_custom_test()
    {
        register_post_type('cts_fruits_test', array(
            'labels' => array(
                'menu_name' => 'Fruits Test',
                'name' => 'Fruit Test',
                'singular_name' => 'Fruit Test',
                'all_items' => 'All Fruits Test',
                'add_new_item' => 'Add New Fruit Test',
                'edit_item' => 'Edit Fruit Test',
                'add_new' => 'Add New Fruit Test'
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-carrot',
            'taxonomies' => array('cts_fruits_taxonomy', 'post_tag', 'category')

        ));
    }
}
