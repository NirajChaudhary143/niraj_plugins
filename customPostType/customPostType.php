<?php

use WPMailSMTP\Vendor\Google\Service\Gmail\Label;

/**
 * Plugin Name: Custom Post Type
 * Description: Create a custom post type called Movie. The movie custom post type should accept movie title and movie content. The post type should also have custom metaboxes registered. Simple input text asking for  Movie release date, move director, Movie casts.  
 * Author : Niraj Chaudhary
 * Author URI: #
 * Text Domain: cpt_
 */
include "customMetaBox.php";
class customPostType extends customMetaBox
{
    function __construct()
    {

        add_action('init', array($this, 'cpt_movie_post_type'));
        add_action('add_meta_boxes', array(
            parent::class, 'cpt_movie_metabox'
        ));
        add_action('save_post', array(parent::class, 'cpt_movie_save_fn'));
        add_filter('the_content', array(parent::class, 'cpt_movie_details_fn'));
    }
    public function cpt_movie_post_type()
    {
        register_post_type(
            'cpt_movie',
            array(
                'labels' => array(
                    'name' => __('Movies'),
                    'singular_name' => __('Movie')
                ),
                'public' => true,
                'has_archive' => true,
                'menu_icon' => 'dashicons-video-alt3',
            )
        );
    }
}

new customPostType;
