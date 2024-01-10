<?php
if (isset($_POST['submit'])) {
    $subject = $_POST['subject'];
    $content = $_POST['content'];
    $email = $_POST['email'];
    function get_data_fun($content, $subject, $email)
    {
        echo "Original Content: " . $content;
        $content = apply_filters('modify_content', $content);
        $arr = array(
            'post_title' => $subject,
            'post_content' => $content,
            'post_type' => 'post',
            'post_status' => 'publish',
            'post_author'   => 1,
        );
        wp_insert_post($arr);
        add_action('send_costum_mail', 'send_mail_to', 10, 3);
        do_action('send_costum_mail', $content, $email, $subject);
        echo "<br>Modified Content: " . $content;
    }
    function modify_email_content($content)
    {
        $content = "I am changed by using filter hook";
        return $content;
    }
    function send_mail_to($content, $email, $subject)
    {
        $res = wp_mail($email, $subject, $content);
        if ($res) {
            echo "<br/>Success";
        } else {
            echo "<br/>Unsuccess";
        }
    }
    add_action('get_data', 'get_data_fun', 10, 3);
    add_filter('modify_content', 'modify_email_content');
    do_action('get_data', $content, $subject, $email);
}
