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
<title>Showing Feedback</title>
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
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
<div class="wholeForm">

	<form action="/Helpers/Showing Schedule/feedbackHandle.php" method="post" >
	
		<fieldset <?php if($editAllowed==0){echo "disabled";}?>>
		<div class="info">
	<b>Showing Agent:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $info[9]." ".$info[10]?></b><br/>
	<b>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $info[11]?> </b><br/>
	<b>Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $info[12]?> </b><br/>
	<b>Code:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $info[7]?></b><br/>
	<b>Is property vacant?&nbsp;&nbsp;<?php if($info[4]==0){echo " Yes";}else{echo " No";}?></b><br/>
	<b>Customer Name:&nbsp;&nbsp;&nbsp;<?php echo $info[5]." ".$info[6]?></b>
	</div>
		<legend></legend>
		<div class="interestButton"><label><b>Is the customer interested in the property?</b></label><br>
		<div class="option1">
		<input class="interest" type="radio" name="interest" value=1 <?php if($info[0]==1){echo "checked";}?>>&nbsp;Yes&nbsp;&nbsp;
		<input class="interest" type="radio" name="interest" value=0 <?php if($info[0]==0){echo "checked";}?>>&nbsp;No<br>
		</div>
		</div>
		<br>
		<div class="experience">
		<label><b>How would you rate your overall experience at this showing?</b></label><br>
		<div class="option2">
		<input type="radio" name="experience" value=0 <?php if($info[1]==0){echo "checked";}?>>&nbsp;Very Poor&nbsp;&nbsp;&nbsp;
		<input type="radio" name="experience" value=1 <?php if($info[1]==1){echo "checked";}?>>&nbsp;Poor&nbsp;&nbsp;&nbsp;
		<input type="radio" name="experience" value=2 <?php if($info[1]==2){echo "checked";}?>>&nbsp;Average&nbsp;&nbsp;&nbsp;
		<input type="radio" name="experience" value=3 <?php if($info[1]==3){echo "checked";}?>>&nbsp;Good&nbsp;&nbsp;&nbsp;
		<input type="radio" name="experience" value=4 <?php if($info[1]==4){echo "checked";}?>>&nbsp;Excellent&nbsp;&nbsp;&nbsp;<br/>
		</div>
		</div>
		<br>
		<div class="price">
		<label><b>What is your opinion of the price?</b></label><br>
		<div class="option3">
		<textarea name="opinion" rows="3" cols="30"> <?php echo $info[2];?>
    	</textarea>
    	</div>
    	</div>
    	<br>
		<div class="comments">
		<label class= "field" for="additional">Additional Comments:</label><br>
    	<div class="option4">
    	<textarea name="additional" rows="10" cols="30"> <?php echo $info[3];?>
    	</textarea>
    	</div>
    	</div>
    	<br>
    	<input type="hidden" name="showing_id" value="<?php echo $_GET['showing_id']; ?>">
		<input type="hidden" name="MLS" value="<?php echo $_GET['MLS']; ?>">
		<input type="submit" value="Continue">
   		<input type="reset">
		</fieldset>
	</form>
	
	</div>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>

</body>
</html>		
