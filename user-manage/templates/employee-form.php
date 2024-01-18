<div>
    <form action="" enctype="multipart/form-data" method="POST">
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