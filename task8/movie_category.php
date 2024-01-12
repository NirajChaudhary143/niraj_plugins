<?php

/**
 * Text Domain: cmb_
 */
class MovieCategory
{
    public function cmb_add_movie_category_box()
    {
        add_meta_box('cmb_movie_category', 'Movie Category', array($this, 'cmb_movie_category_fn'), 'post', 'side');
    }
    public function cmb_movie_category_fn($post)
    {

?>
        <select name="movie_type" id="">
            <option value="" disabled selected>Select The Movie Category</option>
            <option value="marvel" <?php echo (get_post_meta($post->ID, 'cmb_movie_type', true) == 'marvel' ? 'selected' : '') ?>>Marvel Movie</option>
            <option value="super_hero_movie" <?php echo (get_post_meta($post->ID, 'cmb_movie_type', true) == 'super_hero_movie' ? 'selected' : '') ?>>Super Hero Movie</option>
            <option value="dc_movie" <?php echo (get_post_meta($post->ID, 'cmb_movie_type', true) == 'dc_movie' ? 'selected' : '') ?>>DC Movie</option>
            <option value="hollywood" <?php echo (get_post_meta($post->ID, 'cmb_movie_type', true) == 'hollywood' ? 'selected' : '') ?>>Hollywood Movie</option>
        </select>
<?php
    }
    public function cmb_save_movie_category_fn($post_id)
    {
        if (isset($_POST['movie_type'])) {

            update_post_meta($post_id, 'cmb_movie_type', $_POST['movie_type']);
        }
    }
}
