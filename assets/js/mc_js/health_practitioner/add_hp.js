var base_url = jQuery('.base_url').val();
$(document).ready(function() {
    var $validator = $("#add_hp_form").validate({
        rules: {
           hp_name: {
                required: true
            },
            hp_surname: {
                required: true
		    },
			hp_username: {
                required: true,
				  remote: { 
					url:base_url+"auth/check_hp_username", 
					data: {'role_id':'3'},
					async:false 
				}
				//remote: base_url+'auth/check_hp_username'
		    },
		    hp_email: {
                required: true,
                email: true,
				remote: { 
					url:base_url+"auth/check_hp_email", 
					data: {'role_id':'3'},
					async:false 
				}
		    },
		    password: {
                required: true,
				minlength: 5
		    },
		    confirm_password: {
                required: true,
                equalTo: '#password'
		    },
		    pin1: {
                required: true,
				number: true
		    },
			pin2: {
                required: true,
				number: true
		    },
			pin3: {
                required: true,
				number: true
		    },
			pin4: {
                required: true,
				number: true
		    },
		    reminder_question: {
                required: true
		    },
		    reminder_answer: {
                required: true
            },
			country: {
               // required: true
            },
		   hp_speciality: {
                required: true,
		    },
			clinic_loc: {
                required: true,
		    },
			/* health_practice_name: {
                required: true,
		    }, */
		    hp_declaration: {
                required: true,
		    },
		    exampleInputHolder: {
                required: true
            },
		    exampleInputExpiration: {
                required: true,
                date: true
            },
		    exampleInputCsv: {
                required: true,
                number: true
            }
			
			
        },
		 messages: {
           hp_username: {
				required: "Username is Required",
				minlength: "Your username must consist of at least 6 characters",
				remote: "Username already taken! please try another.",
			},
		   hp_email: {
				required: "Email is Required",
				remote: "Email already taken! please try another.",
			},
			}
    });
 
    $('#rootwizard').bootstrapWizard({
        'tabClass': 'nav nav-tabs',
        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;
            var $percent = ($current/$total) * 100;
            $('#rootwizard').find('.progress-bar').css({width:$percent+'%'});
        },
        'onNext': function(tab, navigation, index) {
            var $valid = $("#add_hp_form").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
            }
        },
        'onTabClick': function(tab, navigation, index) {
            var $valid = $("#add_hp_form").valid();
            if(!$valid) {
                $validator.focusInvalid();
                return false;
            }
        },
    });
    
    $('.date-picker').datepicker({
        orientation: "top auto",
        autoclose: true
    });
});