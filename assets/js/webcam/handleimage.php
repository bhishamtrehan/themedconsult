 <?php
 date_default_timezone_set('America/Los_Angeles');
session_start();
$_SESSION['id']="1";
$id=$_SESSION['id'];
mysql_connect("localhost","themed","themedconsult@123") or die ("could not connect to data base");
/* mysql_connect("localhost","root","Flash007") or die ("could not connect to data base");*/
mysql_select_db("webimage") or ("couldn't connect to database");
 $name = date('YmdHis');
//echo $path='http://192.168.25.202/themedconsult/assets/js/webcam/';
 $newname= $_SERVER['DOCUMENT_ROOT']."/themedconsult/assets/js/webcam/images/".$name.".jpg";
$file = file_put_contents( $newname, file_get_contents('php://input') );
//print_r($file);

if (!$file) {
    print "Error occured here";
    exit();
}
else
{
    $sql="insert into web_cam_image (id,name,images) values ('','$id'.'$newname')";
    $result=mysql_query($sql);
    $value=mysql_insert_id();
    $_SESSION["myvalue"]=$value;
    
}
$url = 'http://'.$_SERVER['HTTP_HOST'].'/themedconsult/assets/js/webcam/images/'.$name.".jpg";
print "$url\n";

mysql_connect("localhost","themed","themedconsult@123") or die ("could not connect to data base");
/* mysql_connect("localhost","root","Flash007") or die ("could not connect to data base");
 * mysql_select_db("webimage") or ("couldn't connect to database");
 * */
mysql_select_db("themedconsult") or die("couldn't connect to database");

$name = date('YmdHis');
$newname="images/".$name.".jpg";
$file = file_put_contents( $newname, file_get_contents('php://input') );
if (!$file) {
    print "Error occured here";
    exit();
}
else
{
    $sql = "insert into web_cam_image set `id`= '', `name`='".$id."', `images`='".$newname."'";
    $result = mysql_query($sql);
    $value = mysql_insert_id();
    $_SESSION["myvalue"] = $value;
    
}
$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $newname;
print "$url\n";
?>
