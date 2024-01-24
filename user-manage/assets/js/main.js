            /**
            * Editing the table using ajax
            */
            function edit_employee_table(id) {
                var fullname_id = "#fullname_"+id
                var email_id = "#email_"+id
                var contact_number_id = "#contact_"+id
                var user_bio_id = "#user_bio_"+id
                var imageSrc = jQuery("#image_"+id).attr('src');

                jQuery("#image").hide();
                jQuery("#edit_image").empty().append(`<img src='${imageSrc}' width='200px' height='200px'>`)

                jQuery("#edit_form").show();
                jQuery("#submit_btn").val("Update");

                var fullname = jQuery(fullname_id).text();
                jQuery("#fullname").val(fullname);

                var email = jQuery(email_id).text();
                jQuery("#email").val(email);

                var contact_number = jQuery(contact_number_id).text();
                jQuery("#contact_number").val(contact_number);

                var user_bio = jQuery(user_bio_id).text();
                jQuery("#user_bio").val(user_bio);

                jQuery("#employee_id").val(id);
            }
        
            /**
             * delete_employee_table function is used to delete the employee from table
             * @param {integer} id 
             */
            function delete_employee_table(id) {
                var confirmDelete = confirm("Are you sure want to delete employee details.");
                var id = id;
                if (confirmDelete) {
                    jQuery.ajax({
                        url: um_employee_url_obj.ajaxurl,
                        type: "GET",
                        data:{
                           id: id,
                           action: 'delete_emp_data' 
                        },
                        success: function(response){
                            if (response.success) {
                                jQuery("#message").html("<span style='color:white;background-color:red;padding:5px'>Employee Deleted Succesfully</span>")
                                jQuery("#message").fadeOut(5000);
                            }
                            getEmployeeData();
                        }
                    })
                }
            }

        /**
         * getEmployeeData is a function which load the data in employee table
         * 
         * @param {string} [order=""] 
         * @param {string} [orderBy=""] 
         */
            function getEmployeeData(order="",orderBy="") {
                ajaxurl = um_employee_url_obj.ajaxurl;
                jQuery.ajax({
                    type: "GET",
                    url: ajaxurl,
                    data: {
                        action: 'um_get_data',
                        order: order,
                        orderby: orderBy,
                    },
                    success: function (response) {
                        emp_array_data = response.data.emp_data;
                        var i = 0;
                        var html= ''
                        emp_array_data.forEach(element => {
                            html += `<tr>
                                <td>${++i}</td>
                                <td><img id="image_${element.id}" src="${element.picture}"  width="50" height="50"></td>
                                <td>
                                <span id="fullname_${element.id}" ${element.id}">${element.fullname}</span>
                                </td>
                                <td>
                                <span id="email_${element.id}">${element.email}</span>
                                </td>
                                <td>
                                <span id="contact_${element.id}">${element.contact_number}</span>
                                </td>
                                <td>
                                <span id="gender_${element.id}">${element.gender}</span>
                                </td>
                                <td>
                                <span id="user_bio_${element.id}">${element.user_bio}</span>
                                </td>
                                <td>
                                <span class="value_field_${element.id}">${element.employee_status}</span>
                                </td>
                                <td>
                                    <button id="edit_employee_${element.id}" onclick="edit_employee_table(${element.id})">Edit</button>
                                    <button id="delete_employee_${element.id}" onclick="delete_employee_table(${element.id})">Delete</button>
                                </td>
                                </tr>`;
                            });
                            jQuery("#um_emp_table").empty().append(html);
                    }
                });
            }
        
            /**
             * when document get loaded data are extracted using ajax request
             */
            jQuery(document).ready(function( $ ){

            /**
             * function getEmployeeData
             * Fetching the data using ajax adn display it on 
             */
            getEmployeeData();

            $("#edit_form").hide();

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
             * @param {string} fullname 
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
             * @param {string} email 
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
             * @param {string} contact_number 
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
             * @param {string} user_bio 
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
             * @param {string} employee_status 
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
             * @param {string} gender 
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

                    var gender =$("input[name='gender']:checked").val(); 
                    validate_gender(gender);
        
                    
                    // Create a FormData object
                    var formData = new FormData();
                    
                    // Append form data to the FormData object
                    formData.append('fullname', fullname);
                    formData.append('email', email);
                    formData.append('gender', gender);
                    formData.append('contact_number', contact_number);
                    formData.append('user_bio', user_bio);
                    formData.append('employee_status', employee_status);
                    formData.append('nonce', um_employee_url_obj.nonce);
                    
                    // Append the file to FormData
                    formData.append('image', $("#image")[0].files[0]);
                    
                    // if error occurs it will not send ajax request
                    if ($("#error_name").text() || $("#error_email").text() || $("#error_phone_number").text() || $("#error_user_bio").text() || $("#error_status").text() || $("#error_gender").text()) {
                        return;
                    }else{
                        var btnData = $("#submit_btn").val();

                        //if the value of the submit button is Update then we need to update the employee table
                        if (btnData === 'Update') {
                            var id = $("#employee_id").val();
                            var defaultImage = $("#image_"+id).attr('src');
                            formData.append('id',id);
                            formData.append('defaultImage',defaultImage);
                            formData.append('action','um_update_employee_details');
                            $.ajax({
                                url: um_employee_url_obj.ajaxurl,
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response){
                                    jQuery("#edit_form").hide();
                                    getEmployeeData();
                                    if (response.success) {    
                                        $("#message").html('<span style="background-color: green; color:white;padding:4px">User Updated Succesfully.</span>'); 
                                        $("#fullname, #email, #contact_number, #user_bio, #employee_status, #image").val('');
                                        $("input[name='gender']").prop('checked', false);
                                        $("#message").fadeOut(5000);
                                    }
                                }
                            })
                        }else{
                            formData.append('action', 'um_store_data');
                            ajaxurl = um_employee_url_obj.ajaxurl;
                            $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function( response ){
                                    if (response.success) {    
                                        $("#success").html('<span style="background-color: green; color:white;padding:4px">User Register Succesfully.</span>'); 
                                        $("#fullname, #email, #contact_number, #user_bio, #employee_status, #image").val('');
                                        $("input[name='gender']").prop('checked', false);
                                        $("#edit_image").empty();
                                        $("#success").fadeOut(5000);
                                    }    
                                }
                            });
                        }
                    }
                }); 
                
                /**
                 * Order by employee name
                 */
            
                $("#order_emp_select").change(function(){
                    var order = jQuery("#order_emp_select").val();
                    var orderBy = "fullname";
                   getEmployeeData(order,orderBy);
                })

                /**
                 * When click on image it should open the image selection option
                 */
                $("#edit_image").click(function(){
                    $("#image").click();
                });

                $("#image").change(function() {
                    $("#edit_image").empty().append("<div style='color:white;background-color:green; padding:5px'>Image Has been uploaded</div>");
                })
})