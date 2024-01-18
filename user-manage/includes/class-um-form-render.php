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
        // Shortcodes
        add_shortcode('um_registration_employee', array($this, 'um_form_template'));
        add_shortcode('um_employee_table', array($this, 'um_employee_table_template'));

        // Action hooks
        add_action('wp_enqueue_scripts', array($this, 'um_load_scripts'));
        add_action('wp_ajax_um-store-data', array($this, 'um_save_employee_details'));
        add_action('wp_ajax_um-get-data', array($this, 'um_get_employee_details'));
        add_action('um_save_employee_details', array($this, 'um_save_employee_details_fn'), 10, 7);

        // Filter Hooks
        add_filter('um_get_emplaoyee_data', array($this, 'um_get_employee_data_fn'));
    }
    /**
     * um_load_scripts function
     * 
     * Load the scripts
     */

    public function um_load_scripts()
    {
        $data = array();
        // apply_filters get the employee data
        $data = apply_filters('um_get_emplaoyee_data', $data);
        wp_enqueue_script('um_javascript_handler', plugins_url("/assets/js/main.js", __DIR__), array('jquery'), '1.0.0', true);
        wp_localize_script('um_javascript_handler', 'um_employee_url_obj', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('um_employee_nonce'),
            'data'    => $data,
        ));
    }

    /**
     * um_form_template function render the registration form
     */
    public function um_form_template($hook)
    {
        ob_start();
?>
        <div>
            <div id="success"></div>
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
     * um_employee_table_template funtion render the employee tables
     */
    public function um_employee_table_template()
    {
        ob_start();
    ?>
        <div>
            <div id="edit_form">
                
            </div>
            <table>
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Image</th>
                        <th>Employee Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Gender</th>
                        <th>User Bio</th>
                        <th>Employee Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="um_emp_table">

                </tbody>
            </table>
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
            if (isset($_POST['fullname'], $_POST['email'], $_POST['gender'], $_POST['contact_number'], $_POST['user_bio'], $_POST['employee_status'], $_POST['image'])) {
                $fullname = sanitize_text_field($_POST['fullname']);
                $email = sanitize_email($_POST['email']);
                $contact_number = sanitize_text_field($_POST['contact_number']);
                $gender = sanitize_text_field($_POST['gender']);
                $user_bio = sanitize_textarea_field($_POST['user_bio']);
                $employee_status = sanitize_text_field($_POST['employee_status']);
                $image = sanitize_text_field($_POST['image']);
                // do_action to store the data
                do_action('um_save_employee_details', $fullname, $email, $contact_number, $gender, $user_bio, $employee_status, $image);
            } else {
                wp_send_json_error(array('message' => 'Incomplete data received.'));
            }
        } else {
            wp_send_json_error(array('message' => 'Nonce verification failed.'));
        }
    }

    /**
     * um_save_employee_details_fn function save the data in database
     * 
     * When do_action is called then data is stored in data base
     * 
     * @param string $fullname, $email, $contact_number, $gender, $user_bio, $employee_status, $image
     */

    public function um_save_employee_details_fn($fullname, $email, $contact_number, $gender, $user_bio, $employee_status, $image)
    {
        $data = array(
            'fullname' => $fullname,
            'email' => $email,
            'contact_number' => $contact_number,
            'gender' => $gender,
            'user_bio' => $user_bio,
            'employee_status' => $employee_status,
            'picture' => $image,
        );

        global $wpdb, $table_prefix;
        $wp_emp = $table_prefix . "emp";
        $wpdb->insert($wp_emp, $data);
        wp_send_json_success(array('message' => 'Data saved successfully.'));
    }

    /**
     * um_get_employee_data_fn function returns the employee data
     * 
     * @param array $data is for returning the employee data
     */
    public function um_get_employee_data_fn($data)
    {
        global $wpdb, $table_prefix;
        $wp_emp = $table_prefix . 'emp';
        $query = "SELECT * FROM $wp_emp";
        $data = $wpdb->get_results($query);
        return $data;
    }

    public function um_get_employee_details()
    {
        $data = $_GET['data'];
        wp_send_json_success(array('emp_data' => $data));
    }
}
new UM_Form_Render();
