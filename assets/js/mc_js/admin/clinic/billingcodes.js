$().ready(function() {
		
		// validate signup form on keyup and submit
		$("#add_billing_form").validate({
			rules: {
				
				    billing_name: {
						      required: true,
						    
						    },
			  		billing_code: {
			                required: true,
							number: true
					    },

					duration: {
			                required: true,
							number: true
					    },
					price: {
			                required: true,
							number: true
					    },
					gst: {
			                required: true,
							
					    },

				// //duration: "required",
				// price: "required",
				// gst: "required",
			
			},
			messages: {
				billing_name: "Please enter your Billing Code Name",
				billing_code: "Please enter your Billing Code Number",
				duration: "Please enter your Number ",
				price: "Please enter your Number ",
				gst: "Please enter your GST",
		
		
			}
		});
		});