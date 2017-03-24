<html>
<head>		
<title>"Edit Listing Photos"</title>
  <?php  //var_dump($_GET);
        include "../dataretriever.php";
  ?>

</head>
<body>
	<!-- action_page.php is a php file that handles the submitted input -->
	<form action="editPhotoHandle.php" method="post" enctype="multipart/form-data" >
		<fieldset>
		<legend>Listing Photos</legend>
		 Select image to upload:<br>
		 <img src="<?php echo checkExist(0);?>" style="width:200px;height:100px;">
    	<input type="file" name="file1">
    	<br>
    	<input type="file" name="file2" > 	<br>
    	 <img src="<?php echo checkExist(1);?>" style="width:200px;height:100px;">
        <input type="file" name="file3"> 	<br>
         <img src="<?php echo checkExist(2);?>" style="width:200px;height:100px;">
    	<input type="file" name="file4"> 	<br>
    	 <img src="<?php echo checkExist(3);?>" style="width:200px;height:100px;">
    	<input type="file" name="file5"> 	<br>
    	 <img src="<?php echo checkExist(4);?>" style="width:200px;height:100px;">
    	<input type="file" name="file6">
    	 <img src="<?php echo checkExist(5);?>" style="width:200px;height:100px;">
		<br>
		<input type="submit" value="Continue">
   		<input type="reset">
        <input type="hidden" name="MLS" value=" <?php echo $_GET['MLS']?>">
		</fieldset>
	</form>
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
		$noImage = "./noimage.png";
		return $noImage;
	}
}
?>
</body>
</html>		
