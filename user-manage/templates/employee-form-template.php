<div>
    <div id="success"></div>
    <form action="" enctype="multipart/form-data" method="POST">
        <?php wp_nonce_field('um_employee_nonce', 'um_employee_nonce'); ?>
        <label for=""><?php _e("Full Name", "user-manage") ?></label>
        <input type="text" id="fullname" name="fullname">
        <div id="error_name" style="color: red;">
        </div>
        <label for=""><?php _e("Email", "user-manage") ?></label>
        <input type="email" id="email" name="email">
        <div id="error_email" style="color: red;">
        </div>
        <label for=""><?php _e("Contact Number", "user-manage") ?></label>
        <input type="text" id="contact_number" name="contact_number">
        <div id="error_phone_number" style="color: red;">
        </div>
        <label for=""><?php _e("Gender", "user-manage") ?></label><br>
        <input type="radio" name="gender" value="male"><label for=""><?php _e("Male", "user-manage") ?></label>
        <input type="radio" name="gender" value="female"><label for=""><?php _e("Female", "user-manage") ?></label>
        <input type="radio" name="gender" value="others"><label for=""><?php _e("Others", "user-manage") ?></label><br>
        <div id="error_gender" style="color: red;">
        </div>
        <label for=""><?php _e("User Bio", "user-manage") ?></label>
        <textarea id="user_bio" rows="3" name="user_bio"></textarea>
        <div id="error_user_bio" style="color: red;">
        </div>
        <label for=""><?php _e("Employee Status", "user-manage") ?></label>
        <select id="employee_status" name="employee_status">
            <option value="" disabled selected><?php _e("Select The Status", "user-manage") ?></option>
            <option value="active"><?php _e("Active", "user-manage") ?></option>
            <option value="diactive"><?php _e("Diactivate", "user-manage") ?></option>
        </select>
        <div id="error_status" style="color: red;">
        </div>
        <label for=""><?php _e("Profile Image", "user-manage") ?></label><br>
        <input type="file" id="image" name="image"><br><br>
        <input type="text" hidden id="employee_id">
        <input type="submit" value="Add Employee" id="submit_btn">
    </form>
</div>