<!DOCTYPE html>
<?php
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/Showing Schedule/dataFormat.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
    $formatted_info = getAgentInfo();
?>
<html>
<head>	
<link
	href="/style/formattingFileShowingSchedule.css"
	type="text/css"
	rel="stylesheet">
<title></title>
<script src="/js/dateFilter.js">
</script>
<link
	href="/js/crayJS/jquery-ui.min.css"
	type="text/css"
	rel="stylesheet">
</head>
<body>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
<script type="text/javascript" src="/js/crayJS/jquery-ui.js"></script>
<script type="text/javascript">
	$(function(){
  		$( '#date' ).datepicker({ minDate: 0 });
	});

	$(function() {
		var availableTags =<?php echo json_encode($formatted_info); ?>;
		$('#selectSAgent').autocomplete({
		source: availableTags,
		change: function (event, ui) {
                if(!ui.item){
                    $('#selectSAgent').val("");
                }
        }
		});
	});
</script>
<div class="wholeForm">
<form name="scheduleForm" action="/Helpers/Showing Schedule/newShowingDataHandle.php" method="post">
	<div class="SAgent">
		<label><b>Enter/Select Showing Agent:</b></label>
  			<input class="selectAgent" id="selectSAgent" name='SAgent' placeholder="Enter text here.." required>
	</div>
	<br/>
	<div class= "timeStart"><label><b>Start Time:</b></label>
		<select name='startHour'>
 			<?php 
 				for($x=1; $x<=12; $x++){
 					echo "<option value=\"".$x."\">".$x."</option>";
 				}
 			?>
		</select>
		<select name='startMin'>
	   		<option value=":00">:00</option>
 	    	<option value=":15">:15</option>
  	    	<option value=":30">:30</option>
 	    	<option value=":45">:45</option>
		</select>
		<select name='startTime'>
	    	<option value="AM">AM</option>
 	    	<option value="PM">PM</option>
		</select>
	</div>
	<br/>
	<div class= "timeEnd"><label><b>End Time:</b></label>
		<select name='endHour'>
 			<?php 
 				for($x=1; $x<=12; $x++){
 					echo "<option value=\"".$x."\">".$x."</option>";
 				}
 			?>
		</select>
		<select name='endMin'>
	    	<option value=":00">:00</option>
 	    	<option value=":15">:15</option>
  	    	<option value=":30">:30</option>
 	    	<option value=":45">:45</option>
		</select>
		<select name='endTime'>
	    	<option value="AM">AM</option>
 	   		<option value="PM">PM</option>
		</select>
	</div> 
	<br/>
	<div class="dateDiv">
  		<label><b>Date (MM/DD/YYYY):</b></label> <input type="text" name="date" id="date" required>
  	</div>
  	<br>
	<div class="names">
  		<label><b>Customer First Name:</b></label><input type="text" name="fname"><br>
  		<label><b>Customer Last Name:</b></label><input type="text" name="lname">
  	</div>
  	<br>
  	<div class="lock">
  		<label><b>Lock Box Code:</b></label><input type="text" name="code" value="N/A">
  	</div>
  	<br>
  	<div class="vacant">
  		<label><b>Is home occupied?</b></label><select name='occupy'>
  			<option value=1>Yes</option>
  			<option value=0>No</option>
  		</select>
  	</div>
  	<br/>
  	<input type="hidden" name="MLS" value="<?php echo $_GET['MLS']; ?>">
  	<input style="margin: auto" class="button" type="submit" value="Submit" name="Submit" onClick="return isValid()"/>
</form>
</div>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
</html>