$(document).ready(function(){
   $("#add_staff_form").validate({
      rules: {
         username: {
            required: true
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
            email: true
         },
         contact: {
            required: true,
            digits: true,
            phone: true
         },
         country: {
            required: true,
         },
         status: {
            required: true,
         }

         },
         messages: {
            username: "Username is Required",
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
               email: "Please Put a Valid E-mail Address"
            },

            contact : {
               required: "Contact is Required",
               digits: "Numbers Only"
            },
            country: "Country is Required",
            status: "Status is Required",

         }
     });
});