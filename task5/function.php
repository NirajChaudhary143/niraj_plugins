<?php
class SubmitForm
{
    private $password, $email, $username, $display_name, $firstname, $lastname, $role, $id;
    function __construct($password, $email, $username, $display_name, $firstname, $lastname, $role)
    {
        $this->password = $password;
        $this->email = $email;
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->role = $role;
        $this->display_name = $display_name;
    }
    function insertUserData()
    {
        $userData = array(
            'user_pass' => $this->password,
            'user_login' => $this->username,
            'user_email' => $this->email,
            'display_name' => $this->display_name,
            'user_nicename' => $this->username
        );
        $this->id = wp_insert_user($userData);
    }
    function insertUserMeta()
    {
        if ($this->id) {
            $metaDataArr = array(
                'first_name' => $this->firstname,
                'last_name' => $this->lastname,
                'role' => $this->role
            );
            foreach ($metaDataArr as $key => $value) {
                update_user_meta($this->id, $key, $value);
            }
            wp_redirect('http://localhost/themeGrill/task3/2024/01/08/title-11/');
        }
    }
}
