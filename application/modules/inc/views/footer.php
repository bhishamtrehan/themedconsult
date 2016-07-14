
<div class="page-footer">
    <div class="container">
      <ul class="footer_links">
        <li><a>Security Features</a></li>
        <li><a>Contact</a></li>
      </ul>
      
      <ul class="footer_links social">
        <li><a class="fa fa-facebook"></a></li>
        <li><a class="fa fa-twitter"></a></li>
        <li><a class="fa fa-youtube"></a></li>
        <li><a class="fa fa-google-plus"></a></li>
        <li><a class="fa fa-pinterest-p"></a></li>
        
      </ul>
<!--        <p class="no-s">2016 &copy; MedConsult.</p>-->
    </div>
</div>
</div><!-- Page Inner -->
</main><!-- Page Content -->
       
<div class="cd-overlay"></div>
<!-- Javascripts -->
<script src="<?php echo base_url();?>assets/plugins/jquery/jquery-2.1.4.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jquery-blockui/jquery.blockui.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/switchery/switchery.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/uniform/jquery.uniform.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/classie/classie.js"></script>
<script src="<?php echo base_url();?>assets/plugins/waves/waves.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/3d-bold-navigation/js/main.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jquery-mockjax-master/jquery.mockjax.js"></script>
<script src="<?php echo base_url();?>assets/plugins/moment/moment.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/js/jquery.datatables.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/x-editable/bootstrap3-editable/js/bootstrap-editable.js"></script>
<script src="<?php echo base_url();?>assets/js/plugins/jQuery-confirm/jquery-confirm.js"></script>
<script src="<?php echo base_url();?>assets/js/mc_js/editor/jquery.jqscribble.js"></script>
<script src="<?php echo base_url();?>assets/js/mc_js/editor/jqscribble.extrabrushes.js"></script>
<script src="<?php echo base_url();?>assets/js/mc_js/editor/jquery.textover.js"></script>
<script src="<?php echo base_url();?>assets/js/modern.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/mc_js/clinics/appointment/medication.js"></script>

</body>
<script type="text/javascript">
	$(document).ready(function(){
      /* search new in header */
      $(".my_search").on("click",function(){
        $(this).parent(".search_outer").toggleClass("active");
      });
      
      
		var base_url = jQuery('.base_url').val();
		$('#notificationDropdown').on('click', function(){
			var countNotify = $('#notification_count').html();

			if(!countNotify)
			{
				
			}
			else
			{
				$('#notification_count').html('');
				var userId =  '<?php echo $this->session->userdata['user_id']; ?>';

				$.ajax({
					type: 'POST',
					url: base_url+'master/markNotificationRead',
					data:{userId:userId},
					dataType: 'HTML',
					success: function(data)
					{
						console.log(data);
					}

				});
			}
			
			
		});
                
                $(".sidebar-pusher").click(function(){
                	 $(".content-wrap").animate({scrollTop : 0},800);
                if ($("body").hasClass("siderbarmenu-active")) {
                        $("body").removeClass("siderbarmenu-active");
                           vph = $(window).height();
                      $('.content-wrap').css({'height': vph + 'px'});

                         
                        }else{
                         $("body").addClass("siderbarmenu-active");
                        }
                  
                  
                   
});
	});

</script>
</html>