<?php
include "function.php";
ob_start();
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $display_name = $_POST['display_name'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $role = $_POST['role'];
    $userObj = new SubmitForm($password, $email, $username, $display_name, $firstname, $lastname, $role);
    $userObj->insertUserData();
    $userObj->insertUserMeta();
}
ob_get_flush();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
</head>

<body>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
        <label for="">Email</label>
        <input type="email" name="email">
        <label for="">Password</label>
        <input type="password" name="password">
        <label for="">Username</label>
        <input type="text" name="username">
        <label for="">Display Name</label>
        <input type="text" name="display_name">
        <label for="">First Name</label>
        <input type="text" name="firstname">
        <label for="">Last Name</label>
        <input type="text" name="lastname">
        <label for="">User Role</label>
        <select name="role" id="">
            <option value="">Select Role</option>
            <option value="subscriber">Subscriber</option>
            <option value="editor">Editor</option>
            <option value="administrator">Administrator</option>
        </select>
        <input type="submit" name="submit" value="Register">
    </form>
</body>

</html>