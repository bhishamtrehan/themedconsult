// This file contains the jQuery functions of groups on clinic module

$(document).ready(function() {
    $('.patientInfo').click(function(){
        var pid = $(this).attr('data-pid');
        $('body').addClass("show_loader");
            $.ajax({
                type: "POST",
                url: baseUrl+"clinic/appointment/showPatientsDetailsbyId", 
                data: "pId="+pid,
                dataType: "html",  
                cache:false,
                success: function (response) {
                    //alert(response);
                    $( ".modal-content" ).html(response);
                    $('body').removeClass("show_loader");
                    $( ".btn-lg" ).trigger( "click" );
                }
            });
    })    


    $('.patientBilling').click(function(){
        var pid = $(this).attr('data-pid');
        $('body').addClass("show_loader");
                $.ajax({
                    type: "POST",
                    url: baseUrl+"clinic/appointment/billing_summerybyId", 
                    data: "pId="+pid,
                    dataType: "html",  
                    cache:false,
                    success: function (response) {
                        //alert(response);
                        $( ".modal-content" ).html(response);
                        $('body').removeClass("show_loader");
                        $( ".btn-lg" ).trigger( "click" );
                    }
                });
    })  

    $('.removefromgrp').click(function(){
        var pid = $(this).attr('data-pid');
        var gid = $(this).attr('data-grp');
        $('body').addClass("show_loader");
                $.ajax({
                    type: "POST",
                    url: baseUrl+"clinic/groups/removeFrmGrp", 
                    data: "pId="+pid+"&gid="+gid,
                    dataType: "html",  
                    cache:false,
                    success: function (response) {
                        $('#patient_'+pid).remove();
                        $('body').removeClass("show_loader");
                       
                    }
                });
    })

});

