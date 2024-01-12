<?php
class customMetaBox
{
    public static function cpt_movie_metabox()
    {
        add_meta_box('cpt_movie_director', 'Movie Director', array(self::class, 'cpt_movie_director_fn'), 'cpt_movie', 'side');
        add_meta_box('cpt_movie_release_date', "Release Date", array(self::class, 'cpt_movie_release_date_fn'), 'cpt_movie', 'side');
        add_meta_box('cpt_movie_casts', "Movie Casts", array(self::class, 'cpt_movie_casts_fn'), 'cpt_movie', 'side');
    }
    public static function cpt_movie_director_fn($post)
    {
        $movieDirector = get_post_meta($post->ID, 'cpt_movie_director', true);
        echo '<input type="text" name="director" value="' . $movieDirector . '">';
    }
    public static function cpt_movie_release_date_fn($post)
    {
        $movieReleaseDate = get_post_meta($post->ID, 'cpt_movie_release_date', true);
        echo '<input type="date" name="movie_release_date" value="' . $movieReleaseDate . '">';
    }
    public static function cpt_movie_casts_fn($post)
    {
        $movieCasts = get_post_meta($post->ID, 'cpt_movie_casts', true);
        echo '<input type="text" name="movie_casts" value="' . $movieCasts . '">';
    }
    public static function cpt_movie_save_fn($post_id)
    {
        if (isset($_POST['director'])) {
            update_post_meta($post_id, 'cpt_movie_director', $_POST['director']);
        }
        if (isset($_POST['movie_release_date'])) {
            update_post_meta($post_id, 'cpt_movie_release_date', $_POST['movie_release_date']);
        }
        if (isset($_POST['movie_casts'])) {
            update_post_meta($post_id, 'cpt_movie_casts', $_POST['movie_casts']);
        }
    }
    public static function cpt_movie_details_fn($content)
    {
        if (is_single()) {
            global $post;
            $cpt_content = get_post_meta($post->ID);

            $details = array(
                'cpt_movie_director' => 'Movie Director',
                'cpt_movie_casts' => 'Movie Casts',
                'cpt_movie_release_date' => 'Movie Release Date',
            );

            $after_content = '';

            foreach ($cpt_content as $key => $values) {
                if (strpos($key, "cpt_") !== false && array_key_exists($key, $details)) {
                    foreach ($values as $value) {
                        $after_content .= $details[$key] . " = " . ucfirst($value) . "<br>";
                    }
                }
            }

            $content .= $after_content;
        }

        return $content;
    }
}
