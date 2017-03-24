<!DOCTYPE html>
<?php
    include "dataretriever.php";
?>
<html>
<head>
<link		
<title>"Edit Listing Photos"</title>
  <?php
         $files = GetFilePathArray();                 
  ?>

</head>
<body>
	<!-- action_page.php is a php file that handles the submitted input -->
	<form action="editPhotoHandle.php" method="post" enctype="multipart/form-data" >
		<fieldset>
		<legend>Listing Photos</legend>
		 Select image to upload:<br>
		 <img src="<?php checkExist(0);?>" style="width:200px;height:100px;">
    	<input type="file" name="file1">
    	<br>
    	<input type="file" name="file2" > 	<br>
    	 <img src="<?php checkExist(1);?>" style="width:200px;height:100px;">
        <input type="file" name="file3"> 	<br>
         <img src="<?php checkExist(2);?>" style="width:200px;height:100px;">
    	<input type="file" name="file4"> 	<br>
    	 <img src="<?php checkExist(3);?>" style="width:200px;height:100px;">
    	<input type="file" name="file5"> 	<br>
    	 <img src="<?php checkExist(4);?>" style="width:200px;height:100px;">
    	<input type="file" name="file6">
    	 <img src="<?php checkExist(5);?>" style="width:200px;height:100px;">
		<br>
		<input type="submit" value="Continue">
   		<input type="reset">
		</fieldset>
	</form>
<?php 
function checkExist($location)
{
	if(array_key_exists( $location, $files))
	{
		return $location;
	}
	else
	{
		$noImage = "./noImage.png";
		return $noImage;
	}
}
?>
</body>
</html>		
