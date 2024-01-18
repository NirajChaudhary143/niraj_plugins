jQuery(document).ready(function( $ ){

    /**
     * Onchange of employee status
    */
    $("#employee_status").change(function(){
        var employee_status =$("#employee_status").val();
        if ( !employee_status ) {
            $("#error_status").text("Please select employee status."); 
        }
        else{
            $("#error_status").text("");    
        }
        
    })

    /**
     * username validation function
     * @param fullname 
    */
    function validate_name( fullname ) {
        let regexName = /^[a-zA-Z\s]+$/
        if ( !fullname ) {
            $("#error_name").text("Please enter employee name.");
        } 
        else if ( !regexName.test( fullname ) ) {
            $("#error_name").text("Please enter valid name.");  
        } 
        else if ( fullname ) {
            $("#error_name").text("");
        }
    }

    /**
     * Employee email validation
     * @param email 
     */
    function  validate_email( email ) {
        let regexEmail = /^[a-z0-9]+@[a-z]+\.[a-z]{2,3}$/;
        if ( !email ) {
            $("#error_email").text("Please enter your email.");
        }
        else if ( !regexEmail.test( email ) ) {
            $("#error_email").text("Please enter valid email.");   
        }
        else{
            $("#error_email").text(""); 
        }
    }
    
    /**
     * Contact number validation
     * @param contact_number 
    */
   function  validate_phone_number( contact_number ) {
       let regexPhone = /^[9]+[0-9]{9}$/
       if ( !contact_number ) {
           $("#error_phone_number").text("Please enter contact number.");
        }
        else if ( !regexPhone.test( contact_number ) ) {
            if ( contact_number.length < 10 ) {  
                $("#error_phone_number").text("Length of the contact number must be 10.");  
            }
            else{
                $("#error_phone_number").text("Please enter valid contact number.");  
            }
        }
        else{
            $("#error_phone_number").text("");  
        }
    }
    
    /**
     * Employee bio validation
     * 
     * @param user_bio 
    */
   
   function validate_user_bio(user_bio) {
       if ( !user_bio ) {
           $("#error_user_bio").text("Please enter employee details.");  
        }
        else if ( user_bio ) {
            $("#error_user_bio").text("");  
        }
    }
    
    /**
     * Validate employee status
     * @param employee_status 
    */
   function validate_status( employee_status ){
       if ( !employee_status ) {
           $("#error_status").text("Please select employee status.");  
        }
        else{
            $("#error_status").text(""); 
        }
    }
    
    /**
     * Validate gender
         * @param gender 
    */
   function validate_gender( gender ){
       if (!gender) {
           $("#error_gender").text("Please select employee gender.");     
            }
            else{
                $("#error_gender").text("");   
            }
        }

        /**
         * After submit button clicked below function run
         */
        $("#submit_btn").click(function( e ){
            e.preventDefault();

            var fullname= $("#fullname").val();
            validate_name(fullname);
            
            var email =$("#email").val();
            validate_email(email);

            var contact_number =$("#contact_number").val();
            validate_phone_number(contact_number);

            var user_bio =$("#user_bio").val();
            validate_user_bio(user_bio);
            
            var employee_status =$("#employee_status").val();
            validate_status(employee_status);

            var image =$("#image").val();
            console.log(image);

            var gender =$("input[name='gender']:checked").val(); 
            validate_gender(gender);

            /**
             * Using ajax for storing the data into database
             * 
             * If any error occurs then don't call ajax request
             */

            if ($("#error_name").text() || $("#error_email").text() || $("#error_phone_number").text() || $("#error_user_bio").text() || $("#error_status").text() || $("#error_gender").text()) {
                return;
            }
            ajaxurl = um_employee_url_obj.ajaxurl;
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'um-store-data',
                    fullname: fullname,
                    email: email,
                    gender: gender,
                    contact_number: contact_number,
                    user_bio: user_bio,
                    employee_status: employee_status,
                    image: image,
                    nonce: um_employee_url_obj.nonce 
                },
                success: function( response ){
                    $("#success").text("User Register Succesfully");
                    
                }
            });
        }); 
    })