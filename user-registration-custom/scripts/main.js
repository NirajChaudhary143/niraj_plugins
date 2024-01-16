jQuery(document).ready(function($) {
    $('#submit_btn').click( function(e) {
        e.preventDefault();
        var username = $("#username").val();
        var user_email = $("#user_email").val();
        var user_pass = $("#user_pass").val();
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'urfc_register_user',
                username : username,
                user_email: user_email,
                first_name: first_name,
                last_name: last_name,
                user_pass: user_pass,
                submit: 'submit'
            },
            success: function(data){
                if (data.success) {
                    $(".status_container").text("User registered succefully");
                }
                $("#username").val('');
                $("#user_email").val('');
                $("#user_pass").val('');
                $("#first_name").val('');
                $("#last_name").val('');
            }
        });
    } )
});