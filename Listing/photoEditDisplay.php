<?php 
	function checkExist($location)
	{   $files = GetFilePathArrayVer2();
		//var_dump($files[$location]);
		if(isset($files[$location]))
		{
			return $files[$location];
		}
		else
		{
			$noImage = "/Helpers/Images/noimage.png";
			return $noImage;
		}
	}
?>

<html>
<head>		
	<title>Edit Listing Photos</title>
	<?php  //var_dump($_GET);
		include $_SERVER['DOCUMENT_ROOT'] . "Helpers/dataRetriever.php";
	?>
</head>
<body>
	 <?php  include $_SERVER['DOCUMENT_ROOT'] . "/header.php" ?>
	<div class="container-fluid">
		<!-- action_page.php is a php file that handles the submitted input -->
		<form action="/Helpers/Listing/editPhotoHandle.php" method="post" enctype="multipart/form-data" >
			<fieldset>
				<h2>Listing Photos</h2>
				<hr/>
				<p>Select image to upload:</p>
				<br/>
				<input type="file" name="file1">
				<img src="<?php echo checkExist(0);?>" style="width:200px;height:100px;">
				<hr/>
				<input type="file" name="file2" > 	
				<img src="<?php echo checkExist(1);?>" style="width:200px;height:100px;">
				<hr/>
				<input type="file" name="file3"> 	
				<img src="<?php echo checkExist(2);?>" style="width:200px;height:100px;">	
				<hr/>
				<input type="file" name="file4"> 
				<img src="<?php echo checkExist(3);?>" style="width:200px;height:100px;">	
				<hr/>
				<input type="file" name="file5"> 
				<img src="<?php echo checkExist(4);?>" style="width:200px;height:100px;">	
				<hr/>
				<input type="file" name="file6">
				<img src="<?php echo checkExist(5);?>" style="width:200px;height:100px;">
				<hr/>
				<input type="submit" value="Continue">
				<input type="reset">
				<input type="hidden" name="MLS" value=" <?php echo $_GET['MLS']?>">
			</fieldset>
		</form>
	</div>
	 <?php  include $_SERVER['DOCUMENT_ROOT'] . "/footer.php" ?>
</body>
</html>		
