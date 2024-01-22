<?php

/**
 * @class   UM_Table_Render
 * 
 * @version 1.0.0
 * 
 * @package UserManage/includes/
 * 
 */
class UM_Table_Render
{
    /**
     * Shortcode : um_employee_table
     * um_employee_table_template funtion render the employee tables
     */
    public function um_employee_table_template()
    {
        ob_start();
        include UM_PATH_DIR . 'templates/employee-table-template.php';
        $html = ob_get_clean();
        return $html;
    }
}
