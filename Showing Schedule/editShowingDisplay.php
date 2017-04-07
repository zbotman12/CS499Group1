<!DOCTYPE html>
<html>

<head>	
<link
	href=formattingFileShowingSchedule.css
	type="text/css"
	rel="stylesheet">
<!-- <meta charset="UTF-8"> -->
<title></title>
<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/Showing Schedule/dataFormat.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
$previous_data_array=getPreviousData();
$formatted_info = getDefinedAgentInfo($previous_data_array["SA_id"]);
?>
<script src="/js/dateFilter.js"></script>
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
<form action="/Helpers/Showing Schedule/editShowingDataHandle.php" method="post">
<div class="SAgent">
	<label><b>Enter/Select Showing Agent:</b></label>
  	<input class="selectAgent" id="selectSAgent" name='SAgent' placeholder="Enter text here.." value="<?php echo $formatted_info[0];?>" required>
	</div><br/>
	
<div class= "timeStart"><label><b>Start Time:</b></label><select name='startHour'>
 		<option value="<?php echo $previous_data_array["startHour"]; ?>"><?php echo $previous_data_array["startHour"]; ?></option>
 		<?php 
 			for($x=1; $x<=12; $x++){
 				if(intval($previous_data_array["startHour"]) != $x)
 				{
 					echo "<option value=\"".$x."\">".$x."</option>";
 				}
 			}
 		?>
	</select>
	<select name='startMin'>
		<option value="<?php echo $previous_data_array["startMin"]; ?>"><?php echo $previous_data_array["startMin"]; ?></option>
	 	<?php 
 			for($x=0; $x<=45; $x+=15){
 				if($x==0)
 				{
 					$str=":00";
 				}else{
 					$str= ":".$x;
 				}
 				
 				if($previous_data_array["startMin"] != $str)
 				{
 					if($x==0)
 					{
 						echo "<option value=\":".$x."0\">:".$x."0</option>";
 					}
 					else
 					{
 						echo "<option value=\":".$x."\">:".$x."</option>";
 					}
 				}
 			}
 		?>
	</select>
	<select name='startTime'>
	 <option value="<?php echo $previous_data_array["startCycle"]; ?>"><?php echo $previous_data_array["startCycle"]; ?></option>
	    <?php 
	    if($previous_data_array["startCycle"] == "PM")
	    {
	    	echo "<option value=\"AM\">AM</option>";
	    }else{
	    	echo "<option value=\"PM\">PM</option>";
	    }
	    ?>
	</select>
	</div>
<br/>
 <div class= "timeEnd"><label><b>End Time:</b></label><select name='endHour'>
 		<option value="<?php echo $previous_data_array["endHour"]; ?>"><?php echo $previous_data_array["endHour"]; ?></option>
		<?php 
 			for($x=1; $x<=12; $x++){
 				if(intval($previous_data_array["endHour"]) != $x)
 				{
 					echo "<option value=\"".$x."\">".$x."</option>";
 				}
 			}
 		?>
	</select>
	<select name='endMin'>
	    <option value="<?php echo $previous_data_array["endMin"]; ?>"><?php echo $previous_data_array["endMin"]; ?></option>
		<?php 
 			for($x=0; $x<=45; $x+=15){
 				if($x==0)
 				{
 					$str=":00";
 				}else{
 					$str= ":".$x;
 				}
 				
 				if($previous_data_array["endMin"] != $str)
 				{
 					if($x==0)
 					{
 						echo "<option value=\":".$x."0\">:".$x."0</option>";
 					}
 					else
 					{
 						echo "<option value=\":".$x."\">:".$x."</option>";
 					}
 				}
 			}
 		?>
	</select>
	<select name='endTime'>
			<option value="<?php echo $previous_data_array["endCycle"]; ?>"><?php echo $previous_data_array["endCycle"]; ?></option>
			    <?php 
	    if($previous_data_array["endCycle"] == "PM")
	    {
	    	echo "<option value=\"AM\">AM</option>";
	    }else{
	    	echo "<option value=\"PM\">PM</option>";
	    }
	    ?>
	</select>
	</div>

  <br/>
  Date (MM/DD/YYYY): <input type="text" name="date" id="date" value="<?php echo $previous_data_array["date"]; ?>"><br>
    Is home occupied?<select name='occupy'>
    	<option value=<?php echo $previous_data_array["occupied"]; ?>><?php echo $previous_data_array["tempOccupy"]; ?></option>
  		<option value=1>Yes</option>
  		<option value=0>No</option>
  </select>

  Customer First Name:<input type="text" name="fname" value="<?php echo $previous_data_array["fname"]; ?>" /><br>
  Customer Last Name:<input type="text" name="lname" value="<?php echo $previous_data_array["lname"]; ?>" /><br>
  Lock Box Code:<input type="text" name="code" value="<?php echo $previous_data_array["code"]; ?>" /><br>
  <input type="hidden" name="showing_id" value="<?php echo $_GET['showing_id'];?>">
  <input type="hidden" name="MLS" value="<?php echo $_GET['MLS']; ?>">
  <input type="hidden" name="original_SA" value= "<?php echo $previous_data_array["SA_id"];?>">
  <input type="submit" value="Submit" name="Submit" onClick = "valid()">
</form>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
</html>
