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
        add_action('wp_ajax_um-update-employee-details', array($this, 'um_update_employee_details_fn'));
        add_action('wp_ajax_delete-emp-data', array($this, 'um_delete_employe_fn'));
        add_action('um_save_employee_details', array($this, 'um_save_employee_details_fn'), 10, 7);

        // Filter Hooks
        add_filter('um_get_emplaoyee_data', array($this, 'um_get_employee_data_fn'), 10, 3);
        add_filter('um_update_emplaoyee_data', array($this, 'um_update_employee_data_fn'), 10, 2);
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
        if (is_user_logged_in()) :
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
        else :
            echo wp_kses_post("<h1>You must logged in first.</h1>");
        endif;
        $html = ob_get_clean();
        return $html;
    }

    /**
     * Shortcode : um_employee_table
     * um_employee_table_template funtion render the employee tables
     */
    public function um_employee_table_template()
    {
        ob_start();
        ?>
        <div>
            <div id="message">
            </div>
            <table>
                <thead>
                    <tr>
                        <th><?php _e("S.N.", "user-manage") ?></th>
                        <th><?php _e('Image', 'user-manage') ?></th>
                        <th>
                            <?php _e('Employee Name', 'user-manage') ?>
                            <select name="order_emp" id="order_emp_select">
                                <option value="" disabled selected><?php _e("Select Order", "user-manage") ?></option>
                                <option value="ASC"><?php _e("Ascending", "user-manage") ?></option>
                                <option value="DESC"><?php _e("Descending", "user-manage") ?></option>
                            </select>
                        </th>
                        <th id="email_order"><?php _e('Email', 'user-manage') ?></th>
                        <th id="contact_number_order"><?php _e('Contact Number', 'user-manage') ?></th>
                        <th id="gender_order"><?php _e('Gender', 'user-manage') ?></th>
                        <th id="user_bio_order"><?php _e('User Bio', 'user-manage') ?></th>
                        <th id="emp_status_order"><?php _e('Employee Status', 'user-manage') ?></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php if (is_user_logged_in()) : ?>
                    <tbody id="um_emp_table">

                    </tbody>
                <?php else : ?>
                    <h1><?php echo _e('You Must Log in first', 'user-manage') ?></h1>
                <?php endif ?>
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
            if (isset($_POST['fullname'], $_POST['email'], $_POST['gender'], $_POST['contact_number'], $_POST['user_bio'], $_POST['employee_status'], $_FILES['image'])) {
                $fullname = sanitize_text_field($_POST['fullname']);
                $email = sanitize_email($_POST['email']);
                $contact_number = sanitize_text_field($_POST['contact_number']);
                $gender = sanitize_text_field($_POST['gender']);
                $user_bio = sanitize_textarea_field($_POST['user_bio']);
                $employee_status = sanitize_text_field($_POST['employee_status']);

                $file = $_FILES['image'];
                $ext = explode('/', $file['type'])[1];
                $file_name = $fullname . '.' . $ext;

                $image = wp_upload_bits($file_name, null, file_get_contents($file['tmp_name']));

                $target_file = $image['url'];
                $userData = [
                    $fullname,
                    $email,
                    $contact_number,
                    $gender,
                    $user_bio,
                    $employee_status,
                    $target_file,
                ];

                // do_action to store the data
                do_action('um_save_employee_details', $userData);
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

    public function um_save_employee_details_fn($userData)
    {
        $data = array(
            'fullname' => sanitize_text_field($userData['fullname']),
            'email' => sanitize_text_field($userData['email']),
            'contact_number' => sanitize_text_field($userData['contact_number']),
            'gender' => sanitize_text_field($userData['gender']),
            'user_bio' => sanitize_textarea_field($userData['user_bio']),
            'employee_status' => sanitize_text_field($userData['employee_status']),
            'picture' => sanitize_text_field($userData['target_file']),
        );

        global $wpdb, $table_prefix;
        $wp_emp = $table_prefix . "emp";
        $wpdb->insert($wp_emp, $data);
        wp_send_json_success(array('message' => 'Data saved successfully.'));
    }

    /**
     * um_get_employee_data_fn function returns the employee data
     * 
     * hooked by custom filter hook : um_get_emplaoyee_data
     * 
     * @param array $data is for returning the employee data
     */
    public function um_get_employee_data_fn($data, $order, $orderBy)
    {
        global $wpdb, $table_prefix;
        $order = sanitize_text_field($order);
        $orderBy = sanitize_sql_orderby($orderBy);
        $wp_emp = $table_prefix . 'emp';
        if ($order != "" && $orderBy != "") {
            if ($order === 'ASC') {
                $query = $wpdb->prepare("SELECT * FROM $wp_emp ORDER BY %s ASC", $orderBy);
                $data = $wpdb->get_results($query);
            } else {
                $query = $wpdb->prepare("SELECT * FROM $wp_emp ORDER BY %s DESC", $orderBy);
                $data = $wpdb->get_results($query);
            }
            return $data;
        } else {
            $query = "SELECT * FROM $wp_emp";
            $data = $wpdb->get_results($query);
            return $data;
        }
    }


    /**
     * um_get_employee_details function handles the action from wp_ajax_um-get-data requests
     */
    public function um_get_employee_details()
    {
        $data = array();
        if (isset($_GET['order'], $_GET['orderby'])) {
            $orderBy = $_GET['orderby'];
            $order = $_GET['order'];
        } else {
            $orderBy = '';
            $order = '';
        }
        // apply_filters get the employee data
        $data = apply_filters('um_get_emplaoyee_data', $data, $order, $orderBy);
        wp_send_json_success(array('emp_data' => $data));
    }

    /**
     * um_update_employee_details_fn function handel the action request from wp_ajax_um-update-employee-details ajax request
     */
    public function um_update_employee_details_fn()
    {
        $id = $_POST['id'];
        $data = array(
            'fullname' => $_POST['fullname'],
            'email' => $_POST['email'],
            'contact' => $_POST['contact'],
            'image' => $_FILES['image'],
            'gender' => $_POST['gender'],
            'user_bio' => $_POST['user_bio'],
            'employee_status' => $_POST['employee_status'],
        );
        $data = apply_filters('um_update_emplaoyee_data', $data, $id);
        wp_send_json_success(array('updated_data' => $data));
    }

    /**
     * um_update_emplaoyee_data_fn function is hooked by custom filer hook um_update_emplaoyee_data
     */
    public function um_update_employee_data_fn($data, $id)
    {
        global $wpdb, $table_prefix;
        $wp_emp = $table_prefix . 'emp';
        $fullname = sanitize_text_field($data['fullname']);
        $contact_number = sanitize_text_field($data['contact']);
        $gender = sanitize_text_field($data['gender']);
        $employee_status = sanitize_text_field($data['employee_status']);
        $email = sanitize_email($data['email']);
        $user_bio = sanitize_text_field($data['user_bio']);
        $id = sanitize_text_field($id);

        $file = $_FILES['image'];
        $ext = explode('/', $file['type'])[1];
        $file_name = $id . '.' . $ext;

        $image = wp_upload_bits($file_name, null, file_get_contents($file['tmp_name']));

        $target_file = $image['url'];

        // Update the data of given id
        $query = $wpdb->prepare("UPDATE `$wp_emp` SET `fullname` = '%s', `email` = '%s', `contact_number` = '%s', `gender` = '%s', `user_bio` = '%s', `employee_status` = '%s',  `picture` = '%s' WHERE `id` = %d", $fullname, $email, $contact_number, $gender, $user_bio, $employee_status, $target_file, $id);
        $wpdb->query($query);
        // Get the data of all employee
        $query = $wpdb->prepare("SELECT * FROM $wp_emp WHERE id = %d", $id);
        $data = $wpdb->get_results($query);
        return $data;
    }
    /**
     * wp_ajax_delete-emp-data ajax actions function
     */
    public function um_delete_employe_fn()
    {
        global $wpdb, $table_prefix;
        $wp_emp = $table_prefix . 'emp';
        $id = sanitize_text_field($_GET['id']);

        $query = $wpdb->prepare("DELETE FROM $wp_emp WHERE `id` = %d", $id);
        $wpdb->query($query);
        wp_send_json_success();
    }
}
new UM_Form_Render();
