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
        add_shortcode('um_registration_employee', array($this, 'um_form_template'));
        add_action('wp_enqueue_scripts', array($this, 'um_load_scripts'));
        add_action('wp_ajax_um-store-data', array($this, 'um_save_employee_details'));
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
    public function um_form_template($hook)
    {
        ob_start();
?>
        <div>
            <div id="success" style="background-color: green; color:white;padding:4px"></div>
            <form action="" enctype="multipart/form-data" method="POST">
                <?php wp_nonce_field('um_employee_nonce', 'um_employee_nonce'); ?>
                <label for="">Full Name</label>
                <input type="text" id="fullname">
                <div id="error_name" style="color: red;">
                </div>
                <label for="">Email</label>
                <input type="email" id="email">
                <div id="error_email" style="color: red;">
                </div>
                <label for="">Contact Number</label>
                <input type="text" id="contact_number">
                <div id="error_phone_number" style="color: red;">
                </div>
                <label for="">Gender</label><br>
                <input type="radio" name="gender" value="male"><label for="">Male</label>
                <input type="radio" name="gender" value="female"><label for="">Female</label>
                <input type="radio" name="gender" value="others"><label for="">Others</label><br>
                <div id="error_gender" style="color: red;">
                </div>
                <label for="">User Bio</label>
                <textarea id="user_bio" rows="3"></textarea>
                <div id="error_user_bio" style="color: red;">
                </div>
                <label for="">Employee Status</label>
                <select id="employee_status">
                    <option value="" disabled selected>Select The Status</option>
                    <option value="active">Active</option>
                    <option value="diactive">Diactivate</option>
                </select>
                <div id="error_status" style="color: red;">
                </div>
                <label for="">Profile Image</label><br>
                <input type="file" id="image"><br><br>
                <input type="submit" value="Add Employee" id="submit_btn">
            </form>
        </div>
<?php
        $html = ob_get_clean();
        return $html;
    }

    /**
     * After Nonce verification done employee data are stored in database
     * 
     */

    public function um_save_employee_details()
    {
        if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'um_employee_nonce')) {
            // Nonce verification succeeded, process the data and send success response
            if (isset($_POST['fullname'], $_POST['email'], $_POST['gender'], $_POST['contact_number'], $_POST['user_bio'], $_POST['employee_status'])) {
                $fullname = sanitize_text_field($_POST['fullname']);
                $email = sanitize_email($_POST['email']);
                $contact_number = sanitize_text_field($_POST['contact_number']);
                $gender = sanitize_text_field($_POST['gender']);
                $user_bio = sanitize_textarea_field($_POST['user_bio']);
                $employee_status = sanitize_text_field($_POST['employee_status']);

                $data = array(
                    'fullname' => $fullname,
                    'email' => $email,
                    'contact_number' => $contact_number,
                    'gender' => $gender,
                    'user_bio' => $user_bio,
                    'employee_status' => $employee_status,
                    'picture' => 'test',

                );

                global $wpdb, $table_prefix;
                $wp_emp = $table_prefix . "emp";
                $wpdb->insert($wp_emp, $data);
                wp_send_json_success(array('message' => 'Data saved successfully.'));
            } else {
                wp_send_json_error(array('message' => 'Incomplete data received.'));
            }
        } else {
            wp_send_json_error(array('message' => 'Nonce verification failed.'));
        }
    }
}
new UM_Form_Render();
