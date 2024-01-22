            /**
            * Editing the table using ajax
            */
            function edit_employee_table(id) {
                //feild part to get feild id
                var value_field = ".value_field_"+id;
                jQuery(value_field).hide();
        
                var edit_field = ".edit_field_"+id;
                jQuery(edit_field).show();
        
                var edit_employee = "#edit_employee_"+id;
                var update_employee = "#update_employee_"+id;
        
                // toggle edit and update button
                jQuery(edit_employee).hide();
                jQuery(update_employee).show();
            }
        
            /**
             * update_employee_table function updates the employee using ajax
             */
        
            function update_employee_table(id) {
                var edit_fullname = "#edit_fullname_"+id;
                var edit_email = "#edit_email_"+id;
                var edit_contact = "#edit_contact_"+id;
                var edit_user_bio = "#edit_user_bio_"+id;
                var employee_status = "#employee_status_"+id;
                var edit_image = "#edit_image_"+id;
        
        
                // Get the value from edit form input
                var fullname = jQuery(edit_fullname).val();
                var email = jQuery(edit_email).val();
                var contact = jQuery(edit_contact).val();
                var gender = jQuery("input[name='gender']:checked").val();
                var user_bio = jQuery(edit_user_bio).val();
                var val_employee_status = jQuery(employee_status).val();
                var image =  jQuery(edit_image)[0].files[0];
                
                //formdata object
                var emp_data = new FormData();
        
                // employee data array
                emp_data.append('fullname',fullname);
                emp_data.append('email',email);
                emp_data.append('contact',contact);
                emp_data.append('gender',gender);
                emp_data.append('user_bio',user_bio);
                emp_data.append('employee_status',val_employee_status);
                emp_data.append('image',image);
                emp_data.append('id',id);
        
                //Ajax action
                emp_data.append('action','um_update_employee_details');
        
                jQuery.ajax({
                    url: um_employee_url_obj.ajaxurl,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data:  emp_data,
                    success: function(response){
                        getEmployeeData();
                    }
                });
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
                            <form action="" enctype="multipart/form-data" method="POST">
                                <td>${++i}</td>
                                <td><img class="value_field_${element.id}" src="${element.picture}"  width="50" height="50">
                                <input class="edit_field_${element.id}" type="file" id="edit_image_${element.id}" name="image" style="display:none" >
                                </td>
                                <td>
                                <span class="value_field_${element.id}">${element.fullname}</span>
                                <input class="edit_field_${element.id}" id="edit_fullname_${element.id}" type="text"  value="${element.fullname}" style="display:none">
                                </td>
                                <td>
                                <span class="value_field_${element.id}">${element.email}</span>
                                <input class="edit_field_${element.id}" id="edit_email_${element.id}" type="text"  value="${element.email}" style="display:none">
                                </td>
                                <td>
                                <span class="value_field_${element.id}">${element.contact_number}</span>
                                <input class="edit_field_${element.id}" id="edit_contact_${element.id}" type="text"  value="${element.contact_number}" style="display:none">
                                </td>
                                <td>
                                <span class="value_field_${element.id}">${element.gender}</span>
                                <div class="edit_field_${element.id}" id="edit_gender_${element.id}" style="display:none" >
                                <input type="radio" name="gender" value="male" ${element.gender==='male' ? 'checked' : ''} ><label for="">Male</label><br>
                                <input type="radio" name="gender" value="female" ${element.gender==='female' ? 'checked' : ''}><label for="">Female</label><br>
                                <input type="radio" name="gender" value="others"${element.gender==='others' ? 'checked' : ''}><label for="">Others</label>
                                </div>
                                </td>
                                <td>
                                <span class="value_field_${element.id}">${element.user_bio}</span>
                                <input class="edit_field_${element.id}" id="edit_user_bio_${element.id}" type="text"  value="${element.user_bio}" style="display:none">
                                </td>
                                <td>
                                <span class="value_field_${element.id}">${element.employee_status}</span>
                                <div class="edit_field_${element.id}" id="edit_employee_status_${element.id}" style="display:none" >
                                <select id="employee_status_${element.id}">
                                    <option value="" disabled selected>Select The Status</option>
                                    <option value="active">Active</option>
                                    <option value="diactive">Diactivate</option>
                                </select>
                                </div>
                                </td>
                                <td>
                                    <button id="edit_employee_${element.id}" onclick="edit_employee_table(${element.id})">Edit</button>
                                    <button id="update_employee_${element.id}" onclick="update_employee_table(${element.id})" style="display:none">Update</button>
                                    <button id="delete_employee_${element.id}" onclick="delete_employee_table(${element.id})">Delete</button>
                                </td>
                                </form>
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
        
                    var image =$("#image")[0].files[0];
        
                    var gender =$("input[name='gender']:checked").val(); 
                    validate_gender(gender);
        
                    // Create a FormData object
                    var formData = new FormData();
        
                    // Append form data to the FormData object
                    formData.append('action', 'um_store_data');
                    formData.append('fullname', fullname);
                    formData.append('email', email);
                    formData.append('gender', gender);
                    formData.append('contact_number', contact_number);
                    formData.append('user_bio', user_bio);
                    formData.append('employee_status', employee_status);
                    formData.append('nonce', um_employee_url_obj.nonce);
        
                    // Append the file to FormData
                    formData.append('image', $("#image")[0].files[0]);
        
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
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function( response ){
                            if (response.success) {    
                                $("#success").html('<span style="background-color: green; color:white;padding:4px">User Register Succesfully.</span>'); 
                                $("#fullname, #email, #contact_number, #user_bio, #employee_status, #image").val('');
                                $("input[name='gender']").prop('checked', false);
                                $("#success").fadeOut(5000);
                            }
                            
                        }
                    });
                }); 
            
                /**
                 * Order by employee name
                 */
            
                $("#order_emp_select").change(function(){
                    var order = jQuery("#order_emp_select").val();
                    var orderBy = "fullname";
                   getEmployeeData(order,orderBy);
                })
            })