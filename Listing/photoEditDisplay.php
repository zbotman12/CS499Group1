<?php
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/goodAgents.php";
	
	function checkExist($location)
	{
        //Extensions
       	$exts = ["jpeg", "png", "jpg", "gif"];
        $fileNames = array();
        
        //Scan directory for images.
        $dir = $_SERVER['DOCUMENT_ROOT'] . "/Listing/photos/" .  $_GET['MLS'] . "/";
		$photosDir = scandir($dir);
		
		//Remove . and ..
		unset($photosDir[0]);
		unset($photosDir[1]);

		// Generate list of filenames. Check if any of the strings are in the directory.
		foreach($exts as $e) {
			array_push($fileNames, $location . "." . $e);
		}
		$result = array_intersect($fileNames, $photosDir); 
		
		//Reindex array.
		$result = array_values($result);

		if (count($result) >= 1) {
			return "./photos/" . $_GET['MLS'] . "/" . $result[0];
		} else {
			$noImage = "/Helpers/Images/noimage.png";
			return $noImage;
		}
	} 
?>

<html>
<head>		
	<title>Edit Listing Photos</title>
	<?php  //var_dump($_GET);
		
		include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
	?>
</head>
<body>
	 <?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
	<div class="container-fluid">
		<!-- action_page.php is a php file that handles the submitted input -->
		<form action="../Helpers/Listing/editPhotoHandle.php" method="post" enctype="multipart/form-data" >
			<fieldset>
				<h2>Listing Photos</h2>
				<hr/>
				<p>Select image to upload:</p>
				<br/>
				<input type="file" name="1">
				<img src="<?php echo checkExist(1);?>" style="width:200px;height:100px;">
				<hr/>
				<input type="file" name="2" > 	
				<img src="<?php echo checkExist(2);?>" style="width:200px;height:100px;">
				<hr/>
				<input type="file" name="3"> 	
				<img src="<?php echo checkExist(3);?>" style="width:200px;height:100px;">	
				<hr/>
				<input type="file" name="4"> 
				<img src="<?php echo checkExist(4);?>" style="width:200px;height:100px;">	
				<hr/>
				<input type="file" name="5"> 
				<img src="<?php echo checkExist(5);?>" style="width:200px;height:100px;">	
				<hr/>
				<input type="file" name="6">
				<img src="<?php echo checkExist(6);?>" style="width:200px;height:100px;">
				<hr/>
				<input type="submit" value="Continue">
				<input type="reset">
				<input type="hidden" name="MLS" value=" <?php echo $_GET['MLS']?>">
			</fieldset>
		</form>
	</div>
	 <?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
</html>		
