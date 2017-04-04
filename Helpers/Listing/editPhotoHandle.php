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
		//echo "called";
		mkdir($upload_dir, 0777, true);  //create directory if not exist
	}

	//Get all images.
	$images = scandir($upload_dir);
	//var_dump($images);

	unset($images[0]);
	unset($images[1]);

	//var_dump($images);

	for($i = 1; $i <= 6; $i++)
	{

		if (empty($images)) {
			// Get temp name and extenstion 
			$temp = explode(".", $_FILES[$i]["name"]);
			$extension = end($temp);

			// Get image. 
			$image_name=basename($_FILES[$i]['name']);
			$image_name= $i . strrchr($image_name, '.');

			move_uploaded_file($_FILES[$i]['tmp_name'],$upload_dir.$image_name);

		} else {

			//Get image
			$image_name=basename($_FILES[$i]['name']);
			
			//If no image to replace, continue to next loop iteration.
			if(empty($image_name)) {
				continue;
			}

			// Else, assume file exists. 
			// File formats.
			$jpeg = $upload_dir . $i . "." . "jpeg";
			$png  = $upload_dir . $i . "." . "png";
			$jpg  = $upload_dir . $i . "." . "jpg";
			$gif  = $upload_dir . $i . "." . "gif";
			$formats = [$jpg, $jpeg, $jpg, $gif];

			foreach ($formats as $file) {
				// Delete this file if it exists.
				if (file_exists($file)) {
					//var_dump($file);
					unlink($file);
				}
			}

			// Get temp name and extenstion 
			$temp = explode(".", $_FILES[$i]["name"]);
			$extension = end($temp);

			// Get image. 
			$image_name=basename($_FILES[$i]['name']);
			$image_name= $i . strrchr($image_name, '.');

			move_uploaded_file($_FILES[$i]['tmp_name'],$upload_dir.$image_name);
		}

	}
?>

<head>
	<title>Listing Edit</title>
</head>
<body>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
	<div class="container-fluid">
		<h2>Listing Edit</h2>
		<hr/>
		<p>Edit successful</p>
	</div>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
