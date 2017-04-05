<?php
	//Check and make sure we have an active session. If not we need one so send the user to the login page.
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";

	//define("SITE_NAME","localhost:8080:/"); //constant for project name
	//define("SITE_PATH",$_SERVER['DOCUMENT_ROOT']."/".SITE_NAME); //constant for project base directory
	//define("IMAGES_URL",SITE_PATH."/images/"); //constant for image directory
	$upload_base_dir= $_SERVER['DOCUMENT_ROOT'] . "/Listing/photos/";//"/var/www/html/pics/";
	$upload_time_dir=$_SESSION['temp_MLS']."/"; // setup directory name
	$upload_dir = $upload_base_dir.$upload_time_dir;

	if (!file_exists($upload_dir)) {
		//echo "called";
		mkdir($upload_dir, 0777, true);  //create directory if not exist
	}

	for($i = 1; $i <= 6; $i++)
	{
		// Get temp name and extenstion 
		$temp = explode(".", $_FILES['file'.$i]["name"]);
		$extension = end($temp);

		// Get image. 
		$image_name=basename($_FILES['file'.$i]['name']);
		$image_name= $i . strrchr($image_name, '.');

		move_uploaded_file($_FILES['file'.$i]['tmp_name'],$upload_dir.$image_name);

	}// upload file
?>

<head>
	<title>New Listing</title>
</head>
<body>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
	<div class="container-fluid">
		<h2>Listing Creation</h2>
		<hr/>
		Creation complete
	</div>
	<br/>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>