<?php

/**
 * After Nonce verification done employee data are stored in database
 * 
 */
function um_save_employee_details()
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

            $data = array(
                'fullname'          => sanitize_text_field($fullname),
                'email'             => sanitize_email($email),
                'contact_number'    => sanitize_text_field($contact_number),
                'gender'            => sanitize_text_field($gender),
                'user_bio'          => sanitize_textarea_field($user_bio),
                'employee_status'   => sanitize_text_field($employee_status),
                'picture'           => sanitize_text_field($target_file),
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

/**
 * wp_ajax_delete-emp-data ajax actions function
 */
function um_delete_employe_fn()
{
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix . 'emp';

    $id = sanitize_text_field($_GET['id']);

    $query = $wpdb->prepare("DELETE FROM $wp_emp WHERE `id` = %d", $id);
    $wpdb->query($query);
    wp_send_json_success();
}

/**
 * um_update_employee_details_fn function handel the action request from wp_ajax_um-update-employee-details ajax request
 */
function um_update_employee_details_fn()
{
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix . 'emp';

    $id = $_POST['id'];
    $fullname = sanitize_text_field($_POST['fullname']);
    $email = sanitize_email($_POST['email']);
    $contact_number = sanitize_text_field($_POST['contact']);
    $image = sanitize_text_field($_FILES['image']);
    $gender = sanitize_text_field($_POST['gender']);
    $user_bio = sanitize_text_field($_POST['user_bio']);
    $employee_status = sanitize_text_field($_POST['employee_status']);

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

    wp_send_json_success(array('updated_data' => $data));
}
