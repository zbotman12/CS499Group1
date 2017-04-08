<!DOCTYPE html>
<?php

include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/Showing Schedule/FeedbackDataRetriever.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
?>
<html>
<head>
<link
	href="/style/formattingFileFeedback.css"
	type="text/css"
	rel="stylesheet">
<title>"Edit Listing Photos"</title>
  <?php
        // $files = GetFilePathArray();   
        $info= get_FeedbackInfo();

        if($info[8] != $_SESSION['number'])
        {
        	$editAllowed = 0;
        }
        else
        {
        	$editAllowed = 1;
        }
        
  ?>

</head>
<body>
<div class="wholeForm">
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
	<!-- action_page.php is a php file that handles the submitted input -->
	<form action="/Helpers/Showing Schedule/feedbackHandle.php" method="post" >
		<fieldset <?php if($editAllowed==0){echo "disabled";}?>>
		<legend></legend>
		<div class="interestButton"><label><b>Is the customer interested in the property?</b></label><br>
		<input class="interest" type="radio" name="interest" value=1 <?php if($info[0]==1){echo "checked";}?>>Yes
		<input class="interest" type="radio" name="interest" value=0 <?php if($info[0]==0){echo "checked";}?>>No<br>
		</div>
		<div class="experience">
		<label><b>How would you rate your overall experience at this showing?</b></label><br>
		<input type="radio" name="experience" value=0 <?php if($info[1]==0){echo "checked";}?>>Very Poor
		<input type="radio" name="experience" value=1 <?php if($info[1]==1){echo "checked";}?>>Poor
		<input type="radio" name="experience" value=2 <?php if($info[1]==2){echo "checked";}?>>Average
		<input type="radio" name="experience" value=3 <?php if($info[1]==3){echo "checked";}?>>Good
		<input type="radio" name="experience" value=4 <?php if($info[1]==4){echo "checked";}?>>Excellent<br>
		</div>
		<div class="price">
		<label><b>What is your opinion of the price?</b></label><br>
		<textarea name="opinion" rows="3" cols="30"> <?php echo $info[2];?>
    	</textarea>
    	</div>
    	<br>
		<div class="comments">
		<label class= "field" for="additional">Additional Comments:</label><br>
    	<textarea name="additional" rows="10" cols="30"> <?php echo $info[3];?>
    	</textarea>
    	</div>
    	<br>
    	<input type="hidden" name="showing_id" value="<?php echo $_GET['showing_id']; ?>">
		<input type="hidden" name="MLS" value="<?php echo $_GET['MLS']; ?>">
		<input type="submit" value="Continue">
   		<input type="reset">
		</fieldset>
	</form>
	<div class="info">
	<b>Showing Agent: <?php echo $info[9]." ".$info[10]?></b><br/>
	<b>Email: <?php echo $info[11]?> </b><br/>
	<b>Phone: <?php echo $info[12]?> </b><br/>
	<b>Is property vacant? <?php if($info[4]==0){echo " Yes";}else{echo " No";}?></b><br/>
	<b>Code: <?php echo $info[7]?></b><br/>
	<b>Customer Name: <?php echo $info[5]." ".$info[6]?></b>
	</div>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</div>
</body>
</html>		
