var baseUrl = document.location.origin+'/themedconsult/';
$(document).ready(function(){ 

	// init the external events
		$('#external-events div.external-event').each(function() {
		
			var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title
			};
			
			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);
			
			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});
			
		});
		$('.pracCheckboxAll').click(function() {
			if($(this).is(':checked')) 
				$('.filter-appnt-practitioners .pracCheckbox').attr('checked', true);
			else 
				$('.filter-appnt-practitioners .pracCheckbox').attr('checked', false);
		});
		$('.pracCheckbox').click(function(){
			if(!$(this).is(':checked')) {
				$('.pracCheckboxAll').attr('checked', false);
			}
			else {
				if ($('.pracCheckbox:checked').length == $('.pracCheckbox').length) {
				   $('.pracCheckboxAll').attr('checked', true);
				}
			}
				
		});
		
		$('.filter_bttn').click(function(){
			$('.filter-appnt-practitioners').toggle();
		});
                
                $(document).click(function(e){
    if($(e.target).is('.filter_bttn, .filter-appnt-practitioners *, .filter_pracs_dv *, .filter_pracs_dv span, .pracCheckbox'))return;
    $('.filter-appnt-practitioners').hide();
});

               
		
		$('#selectall').click(function(event) {  //on click 
			if(this.checked) { // check select status
				$('.pracCheckbox').each(function() { //loop through each checkbox
					this.checked = true;  //select all checkboxes with class "pracCheckbox"               
				});
			}else{
				$('.pracCheckbox').each(function() { //loop through each checkbox
					this.checked = false; //deselect all checkboxes with class "pracCheckbox"                       
				});         
			}
		});                
                
		
		// init the calendar
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		var baseUrl = document.location.origin+'/themedconsult/';
		var appntSettings;
		jQuery.ajax({
			url: baseUrl+'clinic/appointment/fetch_settings',
			dataType:'json',
                        success:function(response)
			{

                            	appntSettings = response; 
				var month = appntSettings.calendar_month;
				var day = appntSettings.calendar_day;
				var year = appntSettings.calendar_year;
				var mainHeight = ($(window).height()) - ($('.top-bar').height()) - ($('.widget-header').height()) - ($('.fc-header').height()) - (190);
				
					var calendar = $('.calendar').fullCalendar({
					header: {
						left: 'resourceDay, agendaWeek, month',
						center: 'title',
						right: 'prev, next, today'
					},
					contentHeight: '1800',
					year: year,
					month: month,
					date: day,
					titleFormat: 'ddd, MMM dd, yyyy',
                                        columnFormat: {
                                            week: 'ddd d/M',                                            
                                        },
					defaultView: 'resourceDay',
					editable: true,
					droppable: true,
					slotMinutes: appntSettings.duration,
					minTime: appntSettings.start_time,
					maxTime: appntSettings.end_time,
					axisFormat: 'h(:mm)tt',
					selectable: true,
					selectHelper: true,
					selectOverlap: false,
					slotEventOverlap: false,
                    allDaySlot:true,                                        
                    eventDrop: function(event, delta, revertFunc) {
						var startHour 	= event.start.getHours();
						var startMinute = event.start.getMinutes();
						var endHour 	= event.end.getHours();
						var endMinute   = event.end.getMinutes();
						var dateTimestamp = toTimestamp(event.start);
						var endTimestamp = toTimestamp(event.end);
						popitup(baseUrl+'clinic/appointment/edit_appointment?startDate='+dateTimestamp+'&startTime='+startHour+':'+startMinute+'&endTime='+endHour+':'+endMinute+'&endDate='+endTimestamp+'&resource='+event.resourceId+'&appointment_id='+event.id);
						calendar.fullCalendar('unselect');	
					},
					eventResize: function(event, delta, revertFunc) {
						var startHour 	= event.start.getHours();
						var startMinute = event.start.getMinutes();
						var endHour 	= event.end.getHours();
						var endMinute   = event.end.getMinutes();
						var dateTimestamp = toTimestamp(event.start);
						var endTimestamp = toTimestamp(event.end);
						popitup(baseUrl+'clinic/appointment/edit_appointment?startDate='+dateTimestamp+'&startTime='+startHour+':'+startMinute+'&endTime='+endHour+':'+endMinute+'&endDate='+endTimestamp+'&resource='+event.resourceId+'&appointment_id='+event.id);
						calendar.fullCalendar('unselect');	
					},
					select: function(start, end, allDay, event, resourceId, view) {
						
                        if(isOverlapping(toTimestamp(start),toTimestamp(end),calendar,resourceId) == false)
                        {
							if(view.name == 'resourceDay') {
								var startHour 	= start.getHours();
								var startMinute = start.getMinutes();
								var endHour 	= end.getHours();
								var endMinute   = end.getMinutes();
								var dateTimestamp = toTimestamp(start);
								var endTimestamp = toTimestamp(end);
								var patient_rebooking = "";
								if(resourceId == 'undefined')
									resourceId = '';
								if($("#book_another_appnt").html() != "")
									patient_rebooking = '&patient_id='+$("#book_another_appnt").html();
								popitup(baseUrl+'clinic/appointment/add_appointment?startDate='+dateTimestamp+'&startTime='+startHour+':'+startMinute+'&endTime='+endHour+':'+endMinute+'&endDate='+endTimestamp+'&resource='+resourceId+patient_rebooking);
								calendar.fullCalendar('unselect');
							} else {
								alert("Please use day view to book an appointment.");
								calendar.fullCalendar('unselect');
							}
						}
						else
						{
							alert("Selected timeslot is unavailable.");
							calendar.fullCalendar('unselect');
						}
					},    
					eventMouseover: function(calEvent, jsEvent) { 
						var startHour 	= calEvent.start.getHours();
						
						if(startHour < 10)
							startHour = '0'+startHour;
						var startMinute = calEvent.start.getMinutes();
                                                if(startMinute < 10)
							startMinute = '0'+startMinute;
                                                
						var timeStart = startHour+':'+startMinute+':00'; 
						var H = +timeStart.substr(0, 2);
						var h = (H % 12) || 12;
						var ampm = H < 12 ? "AM" : "PM";
						timeStart = h + timeStart.substr(2, 3) + ampm;
						
						var endHour 	= calEvent.end.getHours();
						var endMinute   = calEvent.end.getMinutes();
						if(endHour < 10)
							endHour = '0'+endHour;
                                                    
                                                if(endMinute < 10)
							endMinute = '0'+endMinute;    
						var timeEnd = endHour+':'+endMinute+':00';
						var H = +timeEnd.substr(0, 2);
						var h = (H % 12) || 12;
						var ampm = H < 12 ? "AM" : "PM";
						timeEnd = h + timeEnd.substr(2, 3) + ampm;
						
                                                if(calEvent.image == undefined)
                                                {
                                                    var tooltip = '<div class="tooltipevent"><span class="textspan">Appointment time: '+timeStart+' - '+timeEnd+'<br/><br/>Notes: '+calEvent.notes+'</span></div>';
                                                }
                                                else
                                                {
                                                    var tooltip = '<div class="tooltipevent"><span class="imgspan"><img style="border-radius: 50%;" width="40" height="28" src="'+calEvent.image+'" /></span> <span class="textspan">' + calEvent.title + '<br/>Appointment time: '+timeStart+' - '+timeEnd+'<br/><br/>Notes: '+calEvent.notes+'</span></div>';
                                                }
						
						$("body").append(tooltip);
						$(this).mouseover(function(e) {
							$(this).css('z-index', 10000);
							$('.tooltipevent').fadeIn('500');
							$('.tooltipevent').fadeTo('10', 1.9);
						}).mousemove(function(e) {
							$('.tooltipevent').css('top', e.pageY + 10);
							$('.tooltipevent').css('left', e.pageX + 20);
						});
					},
					eventMouseout: function(calEvent, jsEvent) {
						$(this).css('z-index', 8);
						$('.tooltipevent').remove();
					},
                                        eventAfterRender: function(event, element, view) {  
                                            var width = $(element).width();
                                            var newwidth = parseInt(width) + 10;
                                            //console.log(view);

                                            // Check which class the event has so you know whether it's half or quarter width
//                                            if($(element).hasClass("HalfClass"))
//                                               width = width / 2;
//                                            if($(element).hasClass("QuarterClass"))
//                                               width = width / 4;

                                            // Set the new width
                                            //$(element).css('width', newwidth + 'px');
                                        },
					eventClick: function(calEvent, jsEvent,event) {

					 var resourceId = calEvent.resourceId;
					//;/ alert(resourceId);
					 	//return false;
						var appointment_id=calEvent.id;
						// var start = $.fullCalendar.formatDate(calEvent._start, 'yyyy-MM-dd HH:mm:ss');
						 var dateTimestamp = $.fullCalendar.formatDate(calEvent._start, 'yyyy-MM-dd');
						 var startHour = $.fullCalendar.formatDate(calEvent._start, 'HH');
						 var startMinute = $.fullCalendar.formatDate(calEvent._start, 'mm');
						var endTimestamp = $.fullCalendar.formatDate(calEvent._end, 'yyyy-MM-dd');
						var endHour = $.fullCalendar.formatDate(calEvent._end, 'HH');
						var endMinute = $.fullCalendar.formatDate(calEvent._end, 'mm');

				      //  alert('start: ' + start + '; end: ' + end);

					
						 $.contextMenu({
						        selector: '.fc-event', 
						        trigger: 'left',
						        reposition: true,
						        
						        items: {
						            "edit": {name: "Edit", icon: "",
						            		callback: function(key, options) {
									  		// alert(dateTimestamp);	
									    //      	return false;
										$('body').addClass("show_loader");
										$.ajax({
											type: "POST",
											url: baseUrl+'clinic/appointment/edit_appointment?startDate='+dateTimestamp+'&startTime='+startHour+':'+startMinute+'&endTime='+endHour+':'+endMinute+'&endDate='+endTimestamp+'&resource='+resourceId+'&appointment_id='+calEvent.id, 
											data: "appointment_id="+calEvent.id,
											dataType: "html",  
											cache:false,
											success: function (response) {
												$( ".modal-content" ).html(response);
												$('body').removeClass("show_loader");
												$( ".btn-lg" ).trigger( "click" );
											}
										});

								// popitup(baseUrl+'clinic/appointment/edit_appointment');
						


									        },
									    },
						            "newconsult": {name: "New Consult", icon: "",
						            		callback: function(key, options) {
						
									       $('body').addClass("show_loader");
										   		var url = baseUrl+"clinic/appointment/new_consult/"+appointment_id;
												
												window.open(url, '_blank');
						            			$.ajax({
													type: "POST",
													url: baseUrl+"clinic/appointment/new_consult", 
													data: "appointment_id="+appointment_id,
													dataType: "html",  
													cache:false,
													success: function (response) {
														//$( ".modal-content" ).html(response);
														$('body').removeClass("show_loader");
														//$( ".btn-lg" ).trigger( "click" );
													}
												});
									        },
						        		},
						            "medications": {name: "Medications", icon: "",
						            		callback: function(key, options) {
						            			$('body').addClass("show_loader");

						            			$.ajax({
													type: "POST",
													url: baseUrl+"clinic/appointment/show_medications", 
													data: "appointment_id="+appointment_id,
													dataType: "html",  
													cache:false,
													success: function (response) {
														$( ".modal-content" ).html(response);
														$('body').removeClass("show_loader");
														$( ".btn-lg" ).trigger( "click" );
													}
												});
									        },
						        		},
						        		 "patientGroup": {name: "Add to Patient group", icon: "",
						            		callback: function(key, options) {
						            			$('body').addClass("show_loader");
						            			$.ajax({
													type: "POST",
													url: baseUrl+"clinic/appointment/getClinicGroups", 
													data: "appointment_id="+appointment_id,
													dataType: "html",  
													cache:false,
													success: function (response) {
														$( ".modal-content" ).html(response);
														$('body').removeClass("show_loader");
														$( ".btn-lg" ).trigger( "click" );
													}
												});
									        },
						        		},
						            "conshistory": {name: "Consultation History", icon: "",
					            				callback: function(key, options) {
										          // alert(appointment_id);

										         $('body').addClass("show_loader");
						            			$.ajax({
													type: "POST",
													url: baseUrl+"clinic/appointment/consultation_history", 
													data: "appointment_id="+appointment_id,
													dataType: "html",  
													cache:false,
													success: function (response) {
														//alert(response);
														$( ".modal-content" ).html(response);
														$('body').removeClass("show_loader");
														$( ".btn-lg" ).trigger( "click" );
													}
												});

										        },
						        		},
						            "patientdet": {name: "Patient Details", icon: "",
						            		callback: function(key, options) {
						            			$('body').addClass("show_loader");
						            			$.ajax({
													type: "POST",
													url: baseUrl+"clinic/appointment/showPatientsDetails", 
													data: "appointment_id="+appointment_id,
													dataType: "html",  
													cache:false,
													success: function (response) {
														//alert(response);
														$( ".modal-content" ).html(response);
														$('body').removeClass("show_loader");
														$( ".btn-lg" ).trigger( "click" );
													}
												});
									        },
						        		},
						            "billsum": {name: "Billing Summary", icon: "",
						            		callback: function(key, options) {
									           //alert(appointment_id);
									         	$('body').addClass("show_loader");
						            			$.ajax({
													type: "POST",
													url: baseUrl+"clinic/appointment/billing_summery", 
													data: "appointment_id="+appointment_id,
													dataType: "html",  
													cache:false,
													success: function (response) {
														//alert(response);
														$( ".modal-content" ).html(response);
														$('body').removeClass("show_loader");
														$( ".btn-lg" ).trigger( "click" );
													}
												});
									        },
						        		},

						        		 "Instpatient": {name: "Instructions to Patient", icon: "",
						            		callback: function(key, options) {
									           //alert(appointment_id);
									         	//$('body').addClass("show_loader");
						            			$.ajax({

													type: "POST",
													url: baseUrl+"clinic/appointment/instruction_patient", 
													data: "appointment_id="+appointment_id,
													dataType: "html",  
													cache:false,
													success: function (response) {
														//alert(response);
														$( ".modal-content" ).html(response);
														$('body').removeClass("show_loader");
														$( ".btn-lg" ).trigger( "click" );
													}
												});
									        },
						        		},
						            "fold1": {
							                "name": "status", 
											"default": "left",
											
							                "items": {
											
							                    "1": {"name": "Appointment Confirmation",
							                    	callback: function(key, options) {
											          // alert(key);
													  // $('body').addClass("show_loader");
													  
						            			$.ajax({
													type: "POST",
													url: baseUrl+"clinic/appointment/status_appointments", 
													data: {"appointment_id":appointment_id,"status":key},
													dataType: "html",  
													cache:false,
													success: function (response) {
														
													 $('.event_'+appointment_id).removeClass('confirm_status');
													  $('.event_'+appointment_id).removeClass('orangecolor_status');
													   $('.event_'+appointment_id).removeClass('greencolor_status');
														$('.event_'+appointment_id).removeClass('redcolor_status');
														 $('.event_'+appointment_id).removeClass('paid_status');
														  $('.event_'+appointment_id).removeClass('greycolor_status');
														  $('.event_'+appointment_id).removeClass('yellow_status');
														 
														
														 
													$('.event_'+appointment_id).addClass('confirm_status');
														//$( ".btn-lg" ).trigger( "click" );
													}
												});
											        },
							                	},
							                    "2": { "name": "Arrived","className": "orangecolor",
							                    	callback: function(key, options) {
											         //  alert(key);
													   	$.ajax({
													type: "POST",
													url: baseUrl+"clinic/appointment/status_appointments", 
													data: {"appointment_id":appointment_id,"status":key},
													dataType: "html",  
													cache:false,
													success: function (response) {
													$('.event_'+appointment_id).removeClass('confirm_status');
														  $('.event_'+appointment_id).removeClass('orangecolor_status');
														   $('.event_'+appointment_id).removeClass('greencolor_status');
															$('.event_'+appointment_id).removeClass('redcolor_status');
															 $('.event_'+appointment_id).removeClass('paid_status');
															  $('.event_'+appointment_id).removeClass('greycolor_status');
															  $('.event_'+appointment_id).removeClass('yellow_status');
														$('.event_'+appointment_id).addClass('orangecolor_status');
														
													}
												});
											        },
							                	},
							                    "3": {"name": "With Practitioner","className": "greencolor",
							                    	callback: function(key, options) {
											           //alert(key);
													  	$.ajax({
													type: "POST",
													url: baseUrl+"clinic/appointment/status_appointments", 
													data: {"appointment_id":appointment_id,"status":key},
													dataType: "html",  
													cache:false,
													success: function (response) {
														 $('.event_'+appointment_id).removeClass('confirm_status');
														  $('.event_'+appointment_id).removeClass('orangecolor_status');
														   $('.event_'+appointment_id).removeClass('greencolor_status');
															$('.event_'+appointment_id).removeClass('redcolor_status');
															 $('.event_'+appointment_id).removeClass('paid_status');
															  $('.event_'+appointment_id).removeClass('greycolor_status');
															  $('.event_'+appointment_id).removeClass('yellow_status');
														$('.event_'+appointment_id).addClass('greencolor_status');
													}
												});
											        },
							                	},
							                    "4": {"name": "Unpaid","className": "redcolor",
							                    	callback: function(key, options) {
											          // alert(key);
													   
													   	$.ajax({
													type: "POST",
													url: baseUrl+"clinic/appointment/status_appointments", 
													data: {"appointment_id":appointment_id,"status":key},
													dataType: "html",  
													cache:false,
													success: function (response) {
														 $('.event_'+appointment_id).removeClass('confirm_status');
														  $('.event_'+appointment_id).removeClass('orangecolor_status');
														   $('.event_'+appointment_id).removeClass('greencolor_status');
															$('.event_'+appointment_id).removeClass('redcolor_status');
															 $('.event_'+appointment_id).removeClass('paid_status');
															  $('.event_'+appointment_id).removeClass('greycolor_status');
															  $('.event_'+appointment_id).removeClass('yellow_status');
													$('.event_'+appointment_id).addClass('redcolor_status');
														//alert(response);
														//$( ".modal-content" ).html(response);
														//$('body').removeClass("show_loader");
														//$( ".btn-lg" ).trigger( "click" );
													}
												});
													   
											        },
							                	},
							                    "5": {"name": "Paid","className": "paid",
							                    	callback: function(key, options) {
											          // alert(key);
													   	$.ajax({
													type: "POST",
													url: baseUrl+"clinic/appointment/status_appointments", 
													data: {"appointment_id":appointment_id,"status":key},
													dataType: "html",  
													cache:false,
													success: function (response) {
														 $('.event_'+appointment_id).removeClass('confirm_status');
														  $('.event_'+appointment_id).removeClass('orangecolor_status');
														   $('.event_'+appointment_id).removeClass('greencolor_status');
															$('.event_'+appointment_id).removeClass('redcolor_status');
															 $('.event_'+appointment_id).removeClass('paid_status');
															  $('.event_'+appointment_id).removeClass('greycolor_status');
															  $('.event_'+appointment_id).removeClass('yellow_status');
													$('.event_'+appointment_id).addClass('paid_status');
														//alert(response);
														//$( ".modal-content" ).html(response);
														//$('body').removeClass("show_loader");
														//$( ".btn-lg" ).trigger( "click" );
													}
												});
											        },
							                	},
							                    "6": {"name": "Discharged","className": "greycolor",
							                    	callback: function(key, options) {
											          // alert(key);
													   	$.ajax({
													type: "POST",
													url: baseUrl+"clinic/appointment/status_appointments", 
													data: {"appointment_id":appointment_id,"status":key},
													dataType: "html",  
													cache:false,
													success: function (response) {
														 $('.event_'+appointment_id).removeClass('confirm_status');
														  $('.event_'+appointment_id).removeClass('orangecolor_status');
														   $('.event_'+appointment_id).removeClass('greencolor_status');
															$('.event_'+appointment_id).removeClass('redcolor_status');
															 $('.event_'+appointment_id).removeClass('paid_status');
															  $('.event_'+appointment_id).removeClass('greycolor_status');
															  $('.event_'+appointment_id).removeClass('yellow_status');
													$('.event_'+appointment_id).addClass('greycolor_status');
														//alert(response);
														//$( ".modal-content" ).html(response);
														//$('body').removeClass("show_loader");
														//$( ".btn-lg" ).trigger( "click" );
													}
												});
											        },
							                	},
							                    "7": {"name": "Did not Attend","className": "yellow",
							                    	callback: function(key, options) {
											          // alert(key);
													   	$.ajax({
													type: "POST",
													url: baseUrl+"clinic/appointment/status_appointments", 
													data: {"appointment_id":appointment_id,"status":key},
													dataType: "html",  
													cache:false,
													success: function (response) {
														 $('.event_'+appointment_id).removeClass('confirm_status');
														  $('.event_'+appointment_id).removeClass('orangecolor_status');
														   $('.event_'+appointment_id).removeClass('greencolor_status');
															$('.event_'+appointment_id).removeClass('redcolor_status');
															 $('.event_'+appointment_id).removeClass('paid_status');
															  $('.event_'+appointment_id).removeClass('greycolor_status');
															  $('.event_'+appointment_id).removeClass('yellow_status');
													$('.event_'+appointment_id).addClass('yellow_status');
														//alert(response);
														//$( ".modal-content" ).html(response);
														//$('body').removeClass("show_loader");
														//$( ".btn-lg" ).trigger( "click" );
													}
												});
											        },
							                	},
							                }
							            },
						          "cancel": {name: "cancel", icon: "",
					            				callback: function(key, options) {
										         // alert(key);

									var appointment_id=calEvent.id;

									var appntId = calEvent.id;;
									//var appntDate = $(this).attr('appointment_date');
         							jQuery.confirm({
								        title: 'Cancel Appointment',
								        content: 'Do you want to cancel the appointment?',
								        confirmButton: 'Yes',
								        cancelButton: 'No',
								        confirmButtonClass: 'btn-danger',
								        cancelButtonClass: 'btn-info',
								        opacity:1,
								        confirm: function(){
									        $('body').addClass("show_loader");
											$(window).attr('location', baseUrl+'clinic/appointment/cancel_calendar_appointment?appnt_id='+appntId);
								        },
								        cancel: function(){
								            
								        }
								    });

							
							
							


										        },
						        		},
						            
						        }
						    });

							
					
/*
						$('body').addClass("show_loader");
						$.ajax({
							type: "POST",
							url: baseUrl+"clinic/appointment/show_appointment_detail", 
							data: "appointment_id="+calEvent.id,
							dataType: "html",  
							cache:false,
							success: function (response) {
								$( ".modal-content" ).html(response);
								$('body').removeClass("show_loader");
								$( ".btn-lg" ).trigger( "click" );
                                                                
                                                                $('#generate_invoice_link').click(function(){
                                                                    $('#appoint_invoiceform').submit();
                                                                 });

                                                                 $('form#appoint_invoiceform').submit(function(e) {
                                                                     var form = $(this);				
                                                                     e.preventDefault();	

                                                                     var patient_id = $('#patient_id').val(); 
                                                                     var appoint_id = $('#appoint_id').val();

                                                                     $.ajax({
                                                                             type: "POST",
                                                                             url: baseUrl+"clinic/patients/generate_invoice",
                                                                             data: form.serialize(), // <--- THIS IS THE CHANGE
                                                                             dataType: "html",
                                                                             success: function(data){
                                                                                     //alert(data);                                    
                                                                                     $('.modal-header .close').click();

                                                                                     appoint_popitup(baseUrl+"clinic/patients/open_invoice_info/"+patient_id+"/"+data+"/"+appoint_id)
                                                                             },
                                                                             error: function() { alert("Error saving patient details."); }
                                                                     });

                                                                 });
                                                                
								$('.book_new_appnt').click(function(){
									$("#book_another_appnt").html($(this).attr('id'));
									$('.modal-header .close').trigger('click');
								});
								$('.cancel_appnt').click(function(){
			
         							var appntId = $(this).attr('id');
									var appntDate = $(this).attr('appointment_date');
         							jQuery.confirm({
								        title: 'Cancel Appointment',
								        content: 'Do you want to cancel the appointment?',
								        confirmButton: 'Yes',
								        cancelButton: 'No',
								        confirmButtonClass: 'btn-danger',
								        cancelButtonClass: 'btn-info',
								        opacity:1,
								        confirm: function(){
									        $('body').addClass("show_loader");
											$(window).attr('location', baseUrl+'clinic/appointment/cancel_appointment?appnt_id='+appntId+'&appointment_date='+appntDate);
								        },
								        cancel: function(){
								            
								        }
								    });

								}); 
							},
								error: function (xhr, ajaxOptions, thrownError) {
								alert(xhr.status);
								alert(thrownError);
							}
						});
*/
					},                                        
					editable: true,
					resources: baseUrl+'clinic/appointment/getLocPractitioners',
					events: baseUrl+'clinic/appointment/get_calendar_appointments',
				});
                                
                                $('.fc-button-prev span').click(function(){ 
                                    var date1 = $('.calendar').fullCalendar('prev').fullCalendar('getDate'); 
                                    setnavigate_date(date1);
                                    return false;
                                });

                              

                                $('.fc-button-next span').click(function(){
                                    var date1 = $('.calendar').fullCalendar('next').fullCalendar('getDate');
                                    setnavigate_date(date1);
                                    return false;
                                });  
                                
                                $('.fc-button-today span').click(function(){
                                    $('.calendar').fullCalendar('changeView', 'resourceDay');
                                    var date1 = $('.calendar').fullCalendar('today').fullCalendar('getDate');
                                    setnavigate_date(date1);
                                    return false;
                                });
			}
		});
		
 }); // end ready function
 
 function setnavigate_date(date1)
 { 
     var dayy = date1.getDate();
     var monthh = date1.getMonth()+1;
     var yearr = date1.getFullYear();
     var setdate = monthh+'/'+dayy+'/'+yearr;
     jQuery('#left_clinic_minicalendar').datepicker("setDate", new Date(setdate) );
     jQuery('#hidden_currentdate').val(setdate);
 }

function appoint_popitup(url) {
	//alert('test');
	newwindow=window.open(url,"name","height=470,width=850,top=20,left=20,scrollbars=0,resizable=0,fullscreen=0");

	//if (window.focus) {newwindow.focus()}
        try 
        {
            newwindow.focus();
        } 
        catch (e) 
        {
            //POPUP BLOCKED
             alert('Popup blocker is enabled in your browser! Please add this site to your exception list.');
        }
        
	return false;
}

function popitup(url) {
//alert('here');
     BootstrapDialog.show({
     	cssClass: 'add_c_appointment',
            message: $('<div></div>').load(url)
        });

	  // jQuery('<div>').dialog({
   //          modal: true,
   //          open: function ()
   //          {
   //              jQuery(this).load(url);
   //          },         
   //          height: 400,
   //          width: 800,
   //          title: 'Dynamically Loaded Page'
   //      });
 
	//newwindow=window.open(url,"name","height=450,width=510,top=20,left=20,scrollbars=0,resizable=0,fullscreen=0");
	// if (window.focus) {newwindow.focus()}
 //        try 
 //        {
 //            newwindow.focus();
 //        } 
 //        catch (e) 
 //        {
 //            //POPUP BLOCKED
 //            // alert('Popup blocker is enabled in your browser! Please add this site to your exception list.');
 //        }
	//return false;
}
function toTimestamp(strDate){
 var datum = Date.parse(strDate);
 return datum/1000;
}
function show_appointment() {
	var baseUrl = document.location.origin+'/themedconsult/';
		
}

function isOverlapping(start,end,calendar,rId){
    var array = calendar.fullCalendar('clientEvents');
    for(i in array){ 
        var alldate_start = toTimestamp(array[i].start);
        var alldate_end = toTimestamp(array[i].end);
        if(array[i].resourceId == rId)
        {
            if (end > alldate_start && start < alldate_end){
               return true;
            }
        }
    }
    return false;
}

$('#ID_for_cal_view').on('change', function() {
	var view = $(this).val();
	if(view == 'appointment_view')
	{
		window.location = baseUrl+'clinic/dashboard';
	}
	else
	{
		window.location = baseUrl+'clinic/rosterView';
	}
});


jQuery(document).ajaxComplete(function(){

$('.newmedication').on('click',function(){
	var appId = $(this).attr('data-attr');
	
		$.ajax({
				type: "POST",
				url: baseUrl+"clinic/appointment/add_medication", 
				data: "appId="+appId,
				dataType: "html",  
				cache:false,
				success: function (response) {
					$( ".modal-content" ).html(response);
					$('body').removeClass("show_loader");
					//$( ".btn-lg" ).trigger( "click" );
				}
			});
	})

	$('.okmedic').on('click', function(){
	
	if( $('#medication').val().trim() == ''){ 
	$( '#medication' ).css( "border-color", "red" );
	return false;
	}

	if ($('#dose').val().trim()	== ''){
	$('#dose').css( "border-color", "red" );
	return false;
	}
	if ($('#dose').val().trim() == ''){
	$('#dose').css( "border-color", "red" );
		return false;
	}
	if ($('#route').val().trim() == ''){
	$('#route').css( "border-color", "red" );
		return false;
	}
	if ($('#frequency').val().trim() == ''){
	$('#frequency').css( "border-color", "red" );
		return false;
	}
	if ($('#notes').val().trim() == ''){
	$('#notes').css( "border-color", "red" );
		return false;
	}
	if ($('#startdate').val().trim() == ''){
	$('#startdate').css( "border-color", "red" );
		return false;
	}
	if ($('#enddate').val().trim() == ''){
	$( '#enddate').css( "border-color", "red" );
		return false;
	}
	
	
	
		var info = $('#add_medication').serialize();
		$.ajax({
				type: "POST",
				url: baseUrl+"clinic/appointment/add_medication", 
				data: info,
				dataType: "html",  
				cache:false,
				success: function (response) {
					$( ".modal-content" ).html(response);
					$('body').removeClass("show_loader");
					//$( ".btn-lg" ).trigger( "click" );
				}
			});

		return false;
	})
	
	function status_remove(appointment_id){
	
	 $('.event_'+appointment_id).removeClass('confirm_status');
  $('.event_'+appointment_id).removeClass('orangecolor_status');
   $('.event_'+appointment_id).removeClass('greencolor_status');
	$('.event_'+appointment_id).removeClass('redcolor_status');
	 $('.event_'+appointment_id).removeClass('paid_status');
	  $('.event_'+appointment_id).removeClass('greycolor_status');
	  $('.event_'+appointment_id).removeClass('yellow_status');
}

	
	
});
