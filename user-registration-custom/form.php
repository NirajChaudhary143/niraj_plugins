<?php
do_action('wp_enqueue_scripts');
?>
<form method="POST">
    <label for="">Username</label>
    <input type="text" id="username">
    <br>
    <label for="">First Name</label>
    <input type="text" id="first_name">
    <br>
    <label for="">Last Name</label>
    <input type="text" id="last_name">
    <br>
    <label for="">Email</label>
    <input type="email" id="user_email">
    <br>
    <label for="">Password</label>
    <input type="password" id="user_pass">
    <br>
    <input type="submit" value="Register" id="submit_btn">
</form>
<div class="status_container">

</div>