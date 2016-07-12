$(document).ready(function(){
	var base_url = jQuery('.base_url').val();
	$('.hpActive').on('click', function(){
		var HpID = $(this).attr('data-hpID');
		//alert(HpID);
		$('body').addClass("show_loader");
		$.ajax({
			type:'POST',
			url:base_url+'master/health_practitioner/ActivateAccountByAdmin',
			data:{hpId:HpID},
			dataType:'html',
			success:function(data)
			{
				$('body').removeClass("show_loader");
				location.reload();
			}
		});
	});


	$('.hpInActive').on('click', function(){
		var HpID = $(this).attr('data-hpID');
		
		$('body').addClass("show_loader");
		$.ajax({
			type:'POST',
			url:base_url+'master/health_practitioner/DeactAccountByAdmin',
			data:{hpId:HpID},
			dataType:'html',
			success:function(data)
			{
				$('body').removeClass("show_loader");
				location.reload();
			}
		});
	});









});