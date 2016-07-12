<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- enable media queries for windows phone 8 -->
<meta name="format-detection" content="telephone=no">
<title>Smart-eHealth</title>
<style>
body{font-family: "Open Sans", sans-serif;
		margin: 0;
		padding: 0;
		-ms-text-size-adjust: 100%;
		-webkit-text-size-adjust: 100%;
		}
table, tbody, tr, td {
		box-sizing: border-box;
}
table {
		border-spacing: 0;
}
table td {
		border-collapse: collapse;
}
.ExternalClass {
		width: 100%;
}
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
		line-height: 100%;
}
.main_tab{ width:60%; margin:0 auto;
;}
.ReadMsgBody {
		width: 100%;
		background-color: #ebebeb;
}
table {
		mso-table-lspace: 0pt;
		mso-table-rspace: 0pt;
}

@media screen and (max-width: 767px) {
.main_tab {
		width: 85% !important;
		max-width: 100% !important;
}
}

</style>
</head>
<body>
<!--wrapper-->
<div class="main_tab">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr style="width: 100%; text-align:center; padding: 15px 0 10px; background: #2c8e7c;">
	<td><img style=" margin:13px auto 5px;" alt="Smart-eHealth" src="<?php echo base_url();?>images/shc-logo-white-email.png"></td>
  </tr>
  
  <tr style="width: 100%;">
	<td style="padding: 10px;text-align: justify; border: 1px solid #2c8e7c;">
	<?php echo $mail_content;?>
	</td>
   
  </tr>
   <tr style="background: #2c8e7c; color:#ffffff; text-align:center; font-size:13px;">
	<td style="padding:10px 0;">&copy; <?php echo date("Y").' '.$this->lang->line('copyright');?></td>
  </tr>
</table>
</div>
</body>
</html>