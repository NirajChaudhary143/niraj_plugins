<?php

/**
 * Create shortcode to render the Form in Frontend
 * 
 * @class       UM_Form_Render 
 * @version     1.0.0
 * @package     UserManage/includes/
 * 
 */

class UM_Form_Render
{
    public function __construct()
    {
        include __DIR__ . '/class-um-table-render.php';
        include __DIR__ . '/function-um-form-handler.php';
        include __DIR__ . '/function-um-table-handler.php';
        $table_render = new UM_Table_Render();

        // Shortcodes
        add_shortcode('um_registration_employee', array($this, 'um_form_template'));
        add_shortcode('um_employee_table', array($table_render, 'um_employee_table_template'));

        // Action hooks
        add_action('wp_enqueue_scripts', array($this, 'um_load_scripts'));
        add_action('wp_ajax_um_store_data', 'um_save_employee_details');
        add_action('wp_ajax_um_get_data', 'um_get_employee_details');
        add_action('wp_ajax_um_update_employee_details', 'um_update_employee_details_fn');
        add_action('wp_ajax_delete_emp_data', 'um_delete_employe_fn');
    }

    /**
     * um_load_scripts function
     * 
     * Load the scripts
     */
    public function um_load_scripts()
    {
        wp_enqueue_script('um_javascript_handler', plugins_url("/assets/js/main.js", __DIR__), array('jquery'), '1.0.0', true);
        wp_localize_script('um_javascript_handler', 'um_employee_url_obj', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('um_employee_nonce'),
        ));
    }

    /**
     * um_form_template function render the registration form
     */
    public function um_form_template()
    {
        ob_start();
        if (!is_user_logged_in()) :
            echo wp_kses_post("<h1>You must logged in first.</h1>");
        else :
?>
            <div>
                <div id="success"></div>
                <form action="" enctype="multipart/form-data" method="POST">
                    <?php wp_nonce_field('um_employee_nonce', 'um_employee_nonce'); ?>
                    <label for=""><?php _e("Full Name", "user-manage") ?></label>
                    <input type="text" id="fullname">
                    <div id="error_name" style="color: red;">
                    </div>
                    <label for=""><?php _e("Email", "user-manage") ?></label>
                    <input type="email" id="email">
                    <div id="error_email" style="color: red;">
                    </div>
                    <label for=""><?php _e("Contact Number", "user-manage") ?></label>
                    <input type="text" id="contact_number">
                    <div id="error_phone_number" style="color: red;">
                    </div>
                    <label for=""><?php _e("Gender", "user-manage") ?></label><br>
                    <input type="radio" name="gender" value="male"><label for=""><?php _e("Male", "user-manage") ?></label>
                    <input type="radio" name="gender" value="female"><label for=""><?php _e("Female", "user-manage") ?></label>
                    <input type="radio" name="gender" value="others"><label for=""><?php _e("Others", "user-manage") ?></label><br>
                    <div id="error_gender" style="color: red;">
                    </div>
                    <label for=""><?php _e("User Bio", "user-manage") ?></label>
                    <textarea id="user_bio" rows="3"></textarea>
                    <div id="error_user_bio" style="color: red;">
                    </div>
                    <label for=""><?php _e("Employee Status", "user-manage") ?></label>
                    <select id="employee_status">
                        <option value="" disabled selected><?php _e("Select The Status", "user-manage") ?></option>
                        <option value="active"><?php _e("Active", "user-manage") ?></option>
                        <option value="diactive"><?php _e("Diactivate", "user-manage") ?></option>
                    </select>
                    <div id="error_status" style="color: red;">
                    </div>
                    <label for=""><?php _e("Profile Image", "user-manage") ?></label><br>
                    <input type="file" id="image" name="image"><br><br>
                    <input type="submit" value="Add Employee" id="submit_btn">
                </form>
            </div>
<?php
        endif;
        $html = ob_get_clean();
        return $html;
    }
}
new UM_Form_Render();
