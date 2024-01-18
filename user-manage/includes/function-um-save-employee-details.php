<?php
function um_save_employee_details()
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
