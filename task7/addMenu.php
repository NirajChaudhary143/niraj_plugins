<?php

class AddMenu
{
    public function s_menuadd__movie()
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
        echo "Hello World";
    }
    public function s_movie_settings_fn()
    {
?>
        <form action="options.php" method="POST">
            <?php
            settings_fields('movie_group');
            do_settings_sections('movie-settings');
            submit_button('Submit');
            ?>
        </form>
<?php
    }
}
