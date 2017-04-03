<?php
	//Check and make sure we have an active session. If not we need one so send the user to the login page.
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessioncheck.php";

	define("SITE_NAME","localhost:8080:/"); //constant for project name
	define("SITE_PATH",$_SERVER['DOCUMENT_ROOT']."/".SITE_NAME); //constant for project base directory
	define("IMAGES_URL",SITE_PATH."/images/"); //constant for image directory


	$upload_base_dir= "../../Listing/photos/";//"/var/www/html/pics/";
	$temp = intval($_POST['MLS']);

	//var_dump($temp);

	$upload_time_dir=$temp."/"; // setup directory name
	$upload_dir = $upload_base_dir.$upload_time_dir;
	//var_dump($upload_dir);


	if (!file_exists($upload_dir)) {
		echo "called";
		mkdir($upload_dir, 0777, true);  //create directory if not exist
	}

	for($i = 1; $i <= 6; $i++)
	{
		$image_name=basename($_FILES['file'.$i]['name']);
		$image=time().'_'.$image_name;
		move_uploaded_file($_FILES['file'.$i]['tmp_name'],$upload_dir.$image);
	}
?>

<head>
	<title>Listing Edit</title>
</head>
<body>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/header.php" ?>
	<div class="container-fluid">
		<h2>Listing Edit</h2>
		<hr/>
		<p>Edit successful</p>
	</div>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/footer.php" ?>
</body>
