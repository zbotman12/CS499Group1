<?php
//Check and make sure we have an active session. If not we need one so send the user to the login page.
include './../sessioncheck.php';
define("SITE_NAME","localhost:8080:/"); //constant for project name
define("SITE_PATH",$_SERVER['DOCUMENT_ROOT']."/".SITE_NAME); //constant for project base directory
define("IMAGES_URL",SITE_PATH."/images/"); //constant for image directory
$upload_base_dir= "photos/";//"/var/www/html/pics/";
$upload_time_dir=$_SESSION['$_GET['MLS']']."/"; // setup directory name
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
<head>
</head>
<body>
	<a href="./../landingpagetest.php">Home</a> <br/>
</body>