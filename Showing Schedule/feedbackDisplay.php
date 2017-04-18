<!DOCTYPE html>
<?php
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/Showing Schedule/FeedbackDataRetriever.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
?>
<html>
<head>
	<title>Showing Feedback</title>
	<?php
		// $files = GetFilePathArray();   
		$info= get_FeedbackInfo();
		if($info[8] != $_SESSION['number']) {
			$editAllowed = 0;
		} else {
			$editAllowed = 1;
		}
	?>
	<link
		href="/style/formattingFileFeedback.css"
		type="text/css"
		rel="stylesheet"
	>
	<style>
		.form-group {
			margin-bottom: 0px !important;
		}
	
		.showing-recap {
			margin-left: 0px !important;
			padding-left: 0px !important;
		}
		
		.showing-feedback {
			margin-left: 0px !important;
			padding-left: 0px !important;
		}
	
		.recap-left {
			font-weight: bold;
		}  
		
		.question {
			padding-left: 0 !important;
			padding-bottom: 15px;
		}
		
		.question > label {
			margin-left: 0px;
		}
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$(".fortyFiveChars").keyup(function(){
			  $(this).next().text("Characters remaining: " + (45 - $(this).val().length));
				if ($(this).val().length > 45) {
					$(this).next().css("color", "red");
				} else {
					$(this).next().css("color", "inherit");
				}
			});
			$(".threeHundredChars").keyup(function(){
			  $(this).next().text("Characters remaining: " + (300 - $(this).val().length));
				if ($(this).val().length > 300) {
					$(this).next().css("color", "red");
				} else {
					$(this).next().css("color", "inherit");
				}
			});
			//Call the keyups to count pre-populated characters
			$(".fortyFiveChars").keyup();
			$(".threeHundredChars").keyup();
		});
		</script>
</head>
<body>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
	<div class="container-fluid">
		<div class="container showing-recap">
			<h2>Showing Recap</h2>
			<hr/>
			<!--Showing agent-->
			<span class="recap-left">Showing Agent:</span>
			<span class="recap-right"><?php echo $info[9]." ".$info[10]?></span>
			<br/>
			<!--email-->
			<span class="recap-left">Email:</span>
			<span class="recap-right"><?php echo $info[11]?> </span>
			<br/>
			<!--phone-->
			<span class="recap-left">Phone:</span>
			<span class="recap-right"><?php echo $info[12]?> </span>
			<br/>
			<!--code-->
			<span class="recap-left">Code:</span>
			<span class="recap-right"><?php echo $info[7]?> </span>
			<br/>
			<!--vacant-->
			<span class="recap-left">Is property vacant?</span>
			<span class="recap-right"><?php if($info[4]==0)echo "Yes"; else echo " No";?></span>
			<br/>
			<!--customer name-->
			<span class="recap-left">Customer Name:</span>
			<span class="recap-right"><?php echo $info[5]." ".$info[6]?></span>
			<br/>
		</div>
		<div class="container showing-feedback">
			<h2>Showing Feedback</h2>
			<hr/>
			<form action="/Helpers/Showing Schedule/feedbackHandle.php" method="post">
			<fieldset <?php if($editAllowed==0){echo "disabled";}?>>
				<div class="form-group">
					<!--Interest-->
					<div class="question container">
						<label for="interest">Is the customer interested in the property?</label>
						<br>
						<input class="interest" type="radio" name="interest" value=1 <?php if($info[0]==1) echo "checked"; ?>>Yes</input>
						<input class="interest" type="radio" name="interest" value=0 <?php if($info[0]==0) echo "checked"; ?>>No</input><br/>
					</div>
					<!--Overall experience-->
					<div class="question container">
						<label for="experience">How would you rate your overall experience at this showing?</label>
						<br>
						<input type="radio" name="experience" value=0 <?php if($info[1]==0) echo "checked";?>>Very Poor</input>
						<input type="radio" name="experience" value=1 <?php if($info[1]==1) echo "checked";?>>Poor</input>
						<input type="radio" name="experience" value=2 <?php if($info[1]==2) echo "checked";?>>Average</input>
						<input type="radio" name="experience" value=3 <?php if($info[1]==3) echo "checked";?>>Good</input>
						<input type="radio" name="experience" value=4 <?php if($info[1]==4) echo "checked";?>>Excellent</input>
					</div>
					<!--Opinion of the price-->
					<div class="question container">
						<label for="opinion">What is your opinion of the price?</label>
						<br/>
						<textarea name="opinion" rows="3" cols="30" class="fortyFiveChars"><?php echo $info[2];?></textarea>
						<p class="remainingChars">Characters remaining: 45</p>
					</div>
					<!--Additional comments-->
					<div class="question container">
						<label for="additional">Additional Comments:</label>
						<br/>
						<textarea name="additional" rows="10" cols="30" class="threeHundredChars"><?php echo $info[3];?></textarea>
						<p class="remainingChars">Characters remaining: 300</p>
					</div>
					<!--Buttons & Hiddens-->
					<div class="question container">
						<input type="submit" class="btn btn-default"></button>
						<input type="reset" class="btn btn-default"></button>
						<input type="hidden" name="showing_id" value="<?php echo $_GET['showing_id']; ?>">
						<input type="hidden" name="MLS" value="<?php echo $_GET['MLS']; ?>">
					</div>
				</div>
				</fieldset>
			</form>
		</div>
	</div>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
</html>		
