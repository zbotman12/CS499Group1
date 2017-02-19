<?php
session_start();

define("SITE_NAME","localhost:8080:/"); //constant for project name
define("SITE_PATH",$_SERVER['DOCUMENT_ROOT']."/".SITE_NAME); //constant for project base directory
define("IMAGES_URL",SITE_URL."images/"); //constant for image directory


$upload_base_dir= "photos/";//"/var/www/html/pics/";
$upload_time_dir=$_SESSION['temp_MLS']."/"; // setup directory name
$upload_dir = $upload_base_dir.$upload_time_dir;

if (!file_exists($upload_dir)) {
	echo "called";
	mkdir($upload_dir, 0777, true);  //create directory if not exist
}
for($i = 1; $i <= 6; $i++)
{
	$image_name=basename($_FILES['file'.$i]['name']);
	$image=time().'_'.$image_name;
	move_uploaded_file($_FILES['file'.$i]['tmp_name'],$upload_dir.$image);
}// upload file
?>