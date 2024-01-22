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
        include UM_PATH_DIR . 'includes/class-um-table-render.php';
        include UM_PATH_DIR . 'includes/function-um-form-handler.php';
        include UM_PATH_DIR . 'includes/function-um-table-handler.php';
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
            include UM_PATH_DIR . 'templates/employee-form-template.php';
        endif;
        $html = ob_get_clean();
        return $html;
    }
}
new UM_Form_Render();
