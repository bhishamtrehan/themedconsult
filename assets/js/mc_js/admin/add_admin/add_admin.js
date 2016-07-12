var base_url = jQuery('.base_url').val();
$(document).ready(function(){
   $("#add_staff_form").validate({
      rules: {
         username: {
            required: true,
			  remote: { 
                url:base_url+"auth/check_username", 
                data: {'role_id':'2'},
                async:false 
            }
               },
         password:{
         	required: true,
            minlength : 5,
         },
         passwordc : {
              required: true,
              minlength : 5,
              equalTo : "#password"
         },
         fname: {
            required: true,
         },

         lname: {

            required: true,
         },
         email: {
            required: true,
            email: true,
			  remote: { 
                url:base_url+"auth/check_email", 
                data: {'role_id':'2'},
                async:false 
            }
         },
         contact: {
            required: true,
            digits: true,
         },
         country: {
            required: true,
         },
         status: {
            required: true,
         }

         },
         messages: {
           username: {
				required: "Username is Required",
				minlength: "Your username must consist of at least 6 characters",
				remote: "Username already taken! please try another.",
			},
			 
            password: {
               required: "Password is Required",
               minlength: "Password must be atleast 5 charcters and above",
            },
             passwordc: {
               required: "Confirm Password is Required",
               minlength: "Confirm Password must be atleast 5 charcters and above",
               equalTo: "Confrim Password doesn't match to Password"
            },

            fname: "First Name is Required",
            lname: "Last Name is Required",
            email: {
               required: "E-mail is Required",
               email: "Please Put a Valid E-mail Address",
			   remote: "Email already taken! please try another.",
            },

            contact : {
               required: "Contact is Required",
               digits: "Numbers Only"
            },
            country: "Country is Required",
            status: "Status is Required",

         }
     });

   // var isvalidate=$("#add_staff_form").valid();
            
   //  if(!isvalidate)
   //  {
           
   //      return false;
   //  }
});