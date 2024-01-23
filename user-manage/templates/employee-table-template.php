<div>
    <div id="message">
    </div>
    <div id="edit_form">
        <?php include UM_PATH_DIR . 'templates/employee-form-template.php'; ?>
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