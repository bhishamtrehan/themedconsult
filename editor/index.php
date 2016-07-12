<!DOCTYPE html>
<html lang="en">
	<head>
		<title>PDF edit</title>
		
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width;initial-scale=1.0;maximum-scale=1.0;user-scalable=0;"/>
		<meta name="apple-mobile-web-app-capable" content="yes"/>
		<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
			
		<script src="http://code.jquery.com/jquery-1.5.2.min.js" type="text/javascript" ></script>
		<script src="jquery.jqscribble.js" type="text/javascript"></script>
		<script src="jqscribble.extrabrushes.js" type="text/javascript"></script>
		
		<style>
			.links a {
				padding-left: 10px;
				margin-left: 10px;
				border-left: 1px solid #000;
				text-decoration: none;
				color: #999;
			}
			.links a:first-child {
				padding-left: 0;
				margin-left: 0;
				border-left: none;
			}
			.links a:hover {text-decoration: underline;}
			.column-left {
				display: inline; 
				float: left;
			}
			.column-right {
				display: inline; 
				float: right;
			}
			canvas{
				height: 1500px;
				width: 100%;
			}
		</style>
	</head>
	<body>
		<div style="overflow: hidden; margin-bottom: 5px;">
			<div class="column-left links">
				<strong>BRUSHES:</strong>
				<a href="#" onclick='$("#test").data("jqScribble").update({brush: BasicBrush});'>Basic</a>
				<a href="#" onclick='$("#test").data("jqScribble").update({brush: LineBrush});'>Line</a>
				<a href="#" onclick='$("#test").data("jqScribble").update({brush: CrossBrush});'>Cross</a>
			</div>
			<div class="column-right links">
				<strong>COLORS:</strong>
				<a href="#" onclick='$("#test").data("jqScribble").update({brushColor: "rgb(0,0,0)"});'>Black</a>
				<a href="#" onclick='$("#test").data("jqScribble").update({brushColor: "rgb(255,0,0)"});'>Red</a>
				<a href="#" onclick='$("#test").data("jqScribble").update({brushColor: "rgb(0,255,0)"});'>Green</a>
				<a href="#" onclick='$("#test").data("jqScribble").update({brushColor: "rgb(0,0,255)"});'>Blue</a>
			</div>
		</div>
		<canvas id="test" style="border: 1px solid;"></canvas>
		<div class="links" style="margin-top: 5px;">
			<strong>OPTIONS:</strong>
			<a href="#" onclick='addImage();'>Add Image</a>
			<a href="#" onclick='$("#test").data("jqScribble").clear();'>Clear</a>
			<a href="#" onclick='$("#test").data("jqScribble").save();'>Save</a>
			<a href="#" onclick='save();'>Custom Save</a>
		</div>
		
		<script type="text/javascript">
			function save()
			{
				$("#test").data("jqScribble").save(function(imageData)
				{
					if(confirm("This will write a file using the example image_save.php. Is that cool with you?"))
					{
						$.post('image_save.php', {imagedata: imageData}, function(response)
						{
							$('body').append(response);
						});	
					}
				});
			}
			function addImage()
			{
				var img = prompt("Enter the URL of the image.");
				if(img !== '')$("#test").data("jqScribble").update({backgroundImage: img});
			}
			$(document).ready(function()
			{
				$("#test").jqScribble();
			});
		</script>
	</body>
</html>