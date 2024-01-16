<?php
class UserRegister
{
    public function urfc_register_user_fn()
    {

        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $firstname = $_POST['first_name'];
            $lastname = $_POST['last_name'];
            $user_pass = $_POST['user_pass'];
            $user_email = $_POST['user_email'];

            $userdata = array(
                'user_nicename' => $username,
                'user_email' => $user_email,
                'user_pass' => $user_pass,
                'user_login' => $username
            );
            $id =  wp_insert_user($userdata);
            if ($id) {
                $metaDataArr = array(
                    'first_name' => $firstname,
                    'last_name' => $lastname
                );
                foreach ($metaDataArr as $key => $value) {
                    update_user_meta($id, $key, $value);
                }
                wp_send_json_success();
            }
        }
    }
}
