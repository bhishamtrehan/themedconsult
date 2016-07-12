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
				billing_name: "Please enter your billing Code name",
				billing_code: "Please enter your billing code number",
				duration: "Please enter your duration ",
				price: "Please enter your price ",
				gst: "Please enter your GST",
		
		
			}
		});
		});