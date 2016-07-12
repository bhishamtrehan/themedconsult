var mousePressed = false;
var lastX, lastY;
var ctx;

function InitThis() {
    ctx = document.getElementById('test').getContext("2d");
    $('#test').bind('mousedown touchstart',function (e) {
        mousePressed = true;
        Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false);
    });

    $('#test').bind('mousemove touchmove', function (e) {
        if (mousePressed) {
            Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true);
        }
    });

    $('#test').bind('mouseup',function (e) {
        if (mousePressed) {
            mousePressed = false;
            cPush();
        }
    });
	
    $('#test').bind('mouseleave touchend',function (e) {
        if (mousePressed) {
            mousePressed = false;
            cPush();
        }
    });
	
	

    drawImage();
}

function drawImage() {
	var orgImg = $('#orgImg').val();
	
	 var img = new Image();
	img.src = orgImg;
		img.addEventListener("load", function(){
   
	   var orgHeight = this.naturalHeight;
       var  orgWidth = this.naturalWidth;

        if(orgWidth <= '1170')
        {
        orgWidth = orgWidth;
        }
        else
        {
        orgWidth = '1170';
        }
 
    
    var image = new Image();
    image.src = orgImg;
    $(image).load(function () {
        ctx.drawImage(image, 0, 0, orgWidth, orgHeight);
        cPush();
    });   
});
}

function Draw(x, y, isDown) {
    if (isDown) {
        ctx.beginPath();
        ctx.lineJoin = "round";
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.closePath();
        ctx.stroke();
    }
    lastX = x;
    lastY = y;
}

var cPushArray = new Array();
var cStep = -1;

function cPush() {
    cStep++;
    if (cStep < cPushArray.length) { cPushArray.length = cStep; }
    cPushArray.push(document.getElementById('test').toDataURL());
   // document.title = cStep + ":" + cPushArray.length;
}
function cUndo() {
    if (cStep > 0) {
        cStep--;
        var canvasPic = new Image();
        canvasPic.src = cPushArray[cStep];
        canvasPic.onload = function () { ctx.drawImage(canvasPic, 0, 0); }
        //document.title = cStep + ":" + cPushArray.length;
    }
}
function cRedo() {
    if (cStep < cPushArray.length-1) {
        cStep++;
        var canvasPic = new Image();
        canvasPic.src = cPushArray[cStep];
        canvasPic.onload = function () { ctx.drawImage(canvasPic, 0, 0); }
       // document.title = cStep + ":" + cPushArray.length;
    }
}