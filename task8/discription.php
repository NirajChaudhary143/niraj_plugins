<?php

/**
 * Text Domain: cmb_
 */
class movieDescription
{
    public function cmb_movie_description()
    {
        add_meta_box('cmb_movie_discription', 'Movie Discription', array($this, 'cmb_movie_discription_fn'), 'post', 'side');
    }
    public function cmb_movie_discription_fn($post)
    {
        $movieDisc = get_post_meta($post->ID, 'movie_discription', true);
        error_log($movieDisc);
?>
        <textarea name="movie_discription" id="" cols="30" rows="3"><?php echo $movieDisc; ?></textarea>
<?php
    }
    public function cmb_save_movie_discription_fn($post_id)
    {
        if (isset($_POST['movie_discription'])) {
            update_post_meta($post_id, 'movie_discription', $_POST['movie_discription']);
        }
    }
}
