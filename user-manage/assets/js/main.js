     /**
            * Editing the table using ajax
            */
     function edit_employee_table(id) {
        //feild part to get feild id
        var name_field = "#name_field_"+id;
        var email_field = "#email_field_"+id;
        var gender_field = "#gender_field_"+id;
        var contact_field = "#contact_field_"+id;
        var user_bio_field = "#user_bio_field_"+id;
        var employee_status_field = "#employee_status_field_"+id;

        // edit part
        var edit_fullname = "#edit_fullname_"+id;
        var edit_email = "#edit_email_"+id;
        var edit_contact = "#edit_contact_"+id;
        var edit_gender = "#edit_gender_"+id;
        var edit_user_bio = "#edit_user_bio_"+id;
        var edit_employee_status = "#edit_employee_status_"+id;
        var edit_employee = "#edit_employee_"+id;
        var update_employee = "#update_employee_"+id;
        
        // hide data
        jQuery(name_field).css("display","none");
        jQuery(email_field).css("display","none");
        jQuery(contact_field).css("display","none");
        jQuery(gender_field).css("display","none");
        jQuery(user_bio_field).css("display","none");
        jQuery(employee_status_field).css("display","none");

        // edit
        jQuery(edit_fullname).css("display","block");
        jQuery(edit_email).css("display","block");
        jQuery(edit_contact).css("display","block");
        jQuery(edit_employee_status).css("display","block");
        jQuery(edit_gender).css("display","block");
        jQuery(edit_user_bio).css("display","block");

        // toggle edit and update button
        jQuery(edit_employee).css("display","none");
        jQuery(update_employee).css("display","block");
    }

    /**
     * update_employee_table function updates the employee using ajax
     */

    function update_employee_table(id) {
        var edit_fullname = "#edit_fullname_"+id;
        var edit_email = "#edit_email_"+id;
        var edit_contact = "#edit_contact_"+id;
        var edit_gender = "#edit_gender_"+id;
        var edit_user_bio = "#edit_user_bio_"+id;
        var edit_employee_status = "#edit_employee_status_"+id;

        // Get the value from edit form input
        var fullname = jQuery(edit_fullname).val();
        var email = jQuery(edit_email).val();
        var contact = jQuery(edit_contact).val();
        var gender = jQuery(edit_gender).val();
        var user_bio = jQuery(edit_user_bio).val();
        var employee_status = jQuery(edit_employee_status).val();

        // employee data array
        var dataArr = {
            'fullname':fullname,
            'email':email,
            'contact':contact,
            'gender':gender,
            'user_bio':user_bio,
            'employee_status':employee_status,
        }
        console.log(fullname);
        jQuery.ajax({
            url: um_employee_url_obj.ajaxurl,
            type: "POST",
            data: {
                action: 'um-update-employee-details',
                id: id,
                emp_data: dataArr,
            },
            success: function(response){
                getEmployeeData();
            }
        });
    }

    /**
     * delete_employee_table function is used to delete the employee from table
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
                   action: 'delete-emp-data' 
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
 */
    function getEmployeeData(order="",orderBy="") {
        console.log(order);
        ajaxurl = um_employee_url_obj.ajaxurl;
        jQuery.ajax({
            type: "GET",
            url: ajaxurl,
            data: {
                action: 'um-get-data',
                order: order,
                orderby: orderBy,
            },
            success: function (response) {
                emp_array_data = response.data.emp_data;
                var i = 0;
                var html= ''
                emp_array_data.forEach(element => {
                    /**
                     * Hide edit button when clicked on edit and render update button
                     * 
                     * Hide all values from table which is selected and render input fields
                     */
                    html += `<tr>
                        <td>${++i}</td>
                        <td><img src="${element.picture}"  width="50" height="50"></td>
                        <td><span id="name_field_${element.id}">${element.fullname}</span><input id="edit_fullname_${element.id}" type="text" style="display:none" value="${element.fullname}"></td>
                        <td><span id="email_field_${element.id}">${element.email}</span><input id="edit_email_${element.id}" type="text" style="display:none" value="${element.email}"></td>
                        <td><span id="contact_field_${element.id}">${element.contact_number}</span><input id="edit_contact_${element.id}" type="text" style="display:none" value="${element.contact_number}"></td>
                        <td><span id="gender_field_${element.id}">${element.gender}</span><input id="edit_gender_${element.id}" type="text" style="display:none" value="${element.gender}"></td>
                        <td><span id="user_bio_field_${element.id}">${element.user_bio}</span><input id="edit_user_bio_${element.id}" type="text" style="display:none" value="${element.user_bio}"></td>
                        <td><span id="employee_status_field_${element.id}">${element.employee_status}</span><input id="edit_employee_status_${element.id}" type="text" style="display:none" value="${element.employee_status}"></td>
                        <td>
                            <button id="edit_employee_${element.id}" onclick="edit_employee_table(${element.id})">Edit</button>
                            <button id="update_employee_${element.id}" onclick="update_employee_table(${element.id})" style="display:none">Update</button>
                            <button id="delete_employee_${element.id}" onclick="delete_employee_table(${element.id})">Delete</button>
                        </td>
                        </tr>`;
                    });
                    jQuery("#um_emp_table").empty().append(html);
            }
        });
    }

    /**
     * when page is loaded
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

            var image =$("#image")[0].files[0];
            console.log(image.name);

            var gender =$("input[name='gender']:checked").val(); 
            validate_gender(gender);

            // Create a FormData object
            var formData = new FormData();

            // Append form data to the FormData object
            formData.append('action', 'um-store-data');
            formData.append('fullname', fullname);
            formData.append('email', email);
            formData.append('gender', gender);
            formData.append('contact_number', contact_number);
            formData.append('user_bio', user_bio);
            formData.append('employee_status', employee_status);

            // Append the file to FormData
            formData.append('image', $("#image")[0].files[0]);

            formData.append('nonce', um_employee_url_obj.nonce);

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
