<?php
class movieForm
{
    public function s_menu_movie_init()
    {
        add_settings_section('movie_setting_section', 'Movie Setting', array($this, 'movie_setting_Section_fn'), 'movie-settings');
        register_setting('movie_group', 'name');
        register_setting('movie_group', 'gender');
        register_setting('movie_group', 'hobbies');
        register_setting('movie_group', 'yourself');
        register_setting('movie_group', 'rate');
        add_settings_field('name', 'Name', array($this, 'name_fn'), 'movie-settings', 'movie_setting_section');
        add_settings_field('gender', 'Gender', array($this, 'gender_fn'), 'movie-settings', 'movie_setting_section');
        add_settings_field('hobbies', 'Hobbies', array($this, 'hobby_fn'), 'movie-settings', 'movie_setting_section');
        add_settings_field('yourself', 'Yourself', array($this, 'yourself_fn'), 'movie-settings', 'movie_setting_section');
        add_settings_field('rate', 'Rate Yourself', array($this, 'rate_yourself_fn'), 'movie-settings', 'movie_setting_section');
    }
    public function name_fn()
    {
        $value = get_option('name');
        error_log(print_r($value, true));
        echo '<input type="text" name="name" value="' . $value . '">';
    }
    public function gender_fn()
    {
        $value = get_option('gender');
        echo '<input type="radio" name="gender" value="male"  ' . ($value == "male" ? "checked" : "") . '><label for="">Male</label>
            <input type="radio" name="gender" value="female" ' . ($value == "female" ? "checked" : "") . '><label for="">Female</label>
            <input type="radio" name="gender" value="other" ' . ($value == "other" ? "checked" : "") . '><label for="">Other</label>';
    }
    public function hobby_fn()
    {
        if (get_option('hobbies')) {

            $values = get_option('hobbies');
        }
        $values = array();;
        echo '<input type="checkbox" name="hobbies[]" id="" value="singing" ' . (in_array("singing", $values) ? "checked" : "") . '>
        <label>Singing</label>
        <input type="checkbox" name="hobbies[]" id="" value="dancing" ' . (in_array("dancing", $values) == "dancing" ? "che cked" : "") . '>
        <label>Dancing</label>
        <input type="checkbox" name="hobbies[]" id="" value="coding" ' . (in_array("coding", $values) == "coding" ? "checked" : "") . '>
        <label>Coding</label>
        ';
    }
    public function yourself_fn()
    {
        $value = get_option('yourself');
        echo '<textarea name="yourself" id="" cols="30" rows="3" >' . $value . '</textarea>';
    }
    public function rate_yourself_fn()
    {
        $value = get_option('rate');
        echo '
        <select name="rate" id="">
        <option disabled selected >Choose the number</option>
        <option value="1" ' . ($value == "1" ? "selected" : "") . '>1</option>
        <option value="2" ' . ($value == "2" ? "selected" : "") . '>2</option>
        <option value="3" ' . ($value == "3" ? "selected" : "") . '>3</option>
        <option value="4" ' . ($value == "4" ? "selected" : "") . '>4</option>
        <option value="5" ' . ($value == "5" ? "selected" : "") . '>5</option>
        <option value="6" ' . ($value == "6" ? "selected" : "") . '>6</option>
        <option value="7" ' . ($value == "7" ? "selected" : "") . '>7</option>
        <option value="8" ' . ($value == "8" ? "selected" : "") . '>8</option>
        <option value="9" ' . ($value == "9" ? "selected" : "") . '>9</option>
        <option value="10" ' . ($value == "10" ? "selected" : "") . '>10</option>
        </select>';
    }
    public function movie_setting_Section_fn()
    {
        echo "Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti quo numquam atque officia, tempora laborum omnis. Ipsa ex blanditiis odit quam magni esse hic. Numquam, sint ad dolor non perferendis ab hic!";
    }
}
