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
?>
        <div>
            <div id="message">
            </div>
            <table>
                <thead>
                    <tr>
                        <th><?php esc_html_e("S.N.", "user-manage") ?></th>
                        <th><?php esc_html_e('Image', 'user-manage') ?></th>
                        <th>
                            <?php esc_html_e('Employee Name', 'user-manage') ?>
                            <select name="order_emp" id="order_emp_select">
                                <option value="" disabled selected><?php esc_html_e("Select Order", "user-manage") ?></option>
                                <option value="ASC"><?php esc_html_e("Ascending", "user-manage") ?></option>
                                <option value="DESC"><?php esc_html_e("Descending", "user-manage") ?></option>
                            </select>
                        </th>
                        <th id="email_order"><?php esc_html_e('Email', 'user-manage') ?></th>
                        <th id="contact_number_order"><?php esc_html_e('Contact Number', 'user-manage') ?></th>
                        <th id="gender_order"><?php esc_html_e('Gender', 'user-manage') ?></th>
                        <th id="user_bio_order"><?php esc_html_e('User Bio', 'user-manage') ?></th>
                        <th id="emp_status_order"><?php esc_html_e('Employee Status', 'user-manage') ?></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php if (is_user_logged_in()) : ?>
                    <tbody id="um_emp_table">

                    </tbody>
                <?php else : ?>
                    <h1><?php echo esc_html_e('You Must Log in first', 'user-manage') ?></h1>
                <?php endif ?>
            </table>
        </div>
<?php
        $html = ob_get_clean();
        return $html;
    }
}
