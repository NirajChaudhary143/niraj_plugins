<?php

/**
 * Plugin Name: Custom Meta Box And Post Type
 * Author: Niraj Chaudhary
 * Author URI: #
 * Description: Here we will study about custom metabox and 'post' type
 * Text Domain: cmb_
 * version: 1.0.0
 */
include('movie_category.php');
include('discription.php');
class MetaBox
{
    function __construct()
    {
        $movieObj = new MovieCategory();
        $movieDisc = new movieDescription();
        add_action('add_meta_boxes', array($this, 'cmb_add_custom_box'));
        add_action('save_post', array($this, 'cmb_save_post_fn'));
        add_action('add_meta_boxes', array($movieObj, 'cmb_add_movie_category_box'));
        add_action('save_post', array($movieObj, 'cmb_save_movie_category_fn'));
        add_action('add_meta_boxes', array($movieDisc, 'cmb_movie_description'));
        add_action('save_post', array($movieDisc, 'cmb_save_movie_discription_fn'));
        add_filter('the_content', array($this, 'cmb_render_content'));
    }
    function cmb_add_custom_box()
    {
        add_meta_box('cmb_description', 'Language', array($this, 'cmb_description_fn'), 'post', 'side');
    }
    function cmb_description_fn($post)
    {
        $movie_lang = get_post_meta($post->ID, 'cmb_language', true);
        error_log(print_r($movie_lang, true));
?>
        <input type="text" name="language" value="<?php echo $movie_lang ?>">


<?php
    }
    public function cmb_save_post_fn($post_id)
    {
        if (isset($_POST['language'])) {

            update_post_meta($post_id, 'cmb_language', $_POST['language']);
        }
    }
    public function cmb_render_content($content)
    {
        if (is_single()) {
            $after_content = '';
            global $post;
            $cmb_content = get_post_meta($post->ID);
            foreach ($cmb_content as $key => $values) {
                // error_log(print_r(strpos($key, "cmb_")));
                if (strpos($key, "cmb_") !== false) {
                    foreach ($values as $value) {
                        $after_content .= $key . " = " . ucfirst($value) . "<br>";
                    }
                }
            }
            $content .= $after_content;
        }
        return $content;
    }
}
new MetaBox();
