<?php

/**
 * um_get_employee_details function handles the action from wp_ajax_um_get_data requests
 */
function um_get_employee_details()
{
    $order = isset($_GET['order']) ? $_GET['order'] : '';
    $data = array();

    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix . 'emp';

    if ($order === 'ASC') {
        $query  = "SELECT * FROM $wp_emp ORDER BY `fullname` ASC";
        $data   = $wpdb->get_results($query);
    } else if ($order === 'DESC') {
        $query  = "SELECT * FROM $wp_emp ORDER BY `fullname` DESC";
        $data   = $wpdb->get_results($query);
    } else {
        $query = "SELECT * FROM $wp_emp";
        $data   = $wpdb->get_results($query);
    }
    wp_send_json_success(array('emp_data' => $data));
}
