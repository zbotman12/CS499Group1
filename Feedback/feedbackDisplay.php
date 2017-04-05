<!DOCTYPE html>
<?php
    include "FeedbackDataRetriever.php";
?>
<html>
<head>

<title>"Edit Listing Photos"</title>
  <?php
        // $files = GetFilePathArray();   
        $info= get_FeedbackInfo();
  ?>

</head>
<body>
	<?php include "../header.php" ?>
	<!-- action_page.php is a php file that handles the submitted input -->
	<form action="feedbackHandle.php" method="post" >
		<fieldset>
		<legend></legend>
		Is the customer interested in the property?<br>
		<input type="radio" name="interest" value=1 <?php if($info[0]==1){echo "checked";}?>>Yes
		<input type="radio" name="interest" value=0 <?php if($info[0]==0){echo "checked";}?>>No<br>
		How would you rate your overall experience at this showing?<br>
		<input type="radio" name="experience" value=0 <?php if($info[1]==0){echo "checked";}?>>Very Poor
		<input type="radio" name="experience" value=1 <?php if($info[1]==1){echo "checked";}?>>Poor
		<input type="radio" name="experience" value=2 <?php if($info[1]==2){echo "checked";}?>>Average
		<input type="radio" name="experience" value=3 <?php if($info[1]==3){echo "checked";}?>>Good
		<input type="radio" name="experience" value=4 <?php if($info[1]==4){echo "checked";}?>>Excellent<br>
		What is your opinion of the price?<br>
		<textarea name="opinion" rows="3" cols="30"> <?php echo $info[2];?>
    	</textarea><br>
	
		<label class= "field" for="additional">Additional Comments:</label><br>
    	<textarea name="additional" rows="10" cols="30"> <?php echo $info[3];?>
    	</textarea><br>
    	<input type="hidden" name="showing_id" value="<?php echo $_GET['showing_id']; ?>">
		<input type="hidden" name="MLS" value="<?php echo $_GET['MLS']; ?>">
		<input type="submit" value="Continue">
   		<input type="reset">
		</fieldset>
	</form>
	<b>Showing Agent: <?php echo $info[9]." ".$info[10]?></b><br/>
	<b>Email: <?php echo $info[11]?> </b><br/>
	<b>Phone: <?php echo $info[12]?> </b><br/>
	<b>Is property vacant? <?php if($info[4]==0){echo " Yes";}else{echo " No";}?></b><br/>
	<b>Code: <?php echo $info[7]?></b><br/>
	<b>Customer Name: <?php echo $info[5]." ".$info[6]?></b>
	<b></b>
	<?php include "../footer.php" ?>
<?php 
/*function checkExist($location)
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
}*/
?>
</body>
</html>		
