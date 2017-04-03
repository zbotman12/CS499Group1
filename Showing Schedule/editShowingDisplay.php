<!DOCTYPE html>
<html>
<!-- ISSUE: LINE 18, 154 - change showing_id to $_GET['showing_id'] --> 
<head>	
<link
	href=formattingFileShowingSchedule.css
	type="text/css"
	rel="stylesheet">
<!-- <meta charset="UTF-8"> -->
<title></title>
<?php 
include "dataFormat.php";
$previous_data_array=getPreviousData();
$formatted_info = getDefinedAgentInfo($previous_data_array["SA_id"]);
?>
<script src="dateFilter.js"></script>
</head>
<body>

<!-- action_page.php is a php file that handles the submitted input --> 
<form action="editShowingDataHandle.php" method="post">
Start Time:<select name='startHour'>
	<option value="<?php echo $previous_data_array["startHour"]; ?>"><?php echo $previous_data_array["startHour"]; ?></option>
	<option value="1">1</option>
  	 <option value="2">2</option>
  	 <option value="3">3</option>
  	 <option value="4">4</option>
  	 <option value="5">5</option>
	 <option value="6">6</option>
 	 <option value="7">7</option>
  	 <option value="8">8</option>
 	 <option value="9">9</option>
 	 <option value="10">10</option>
 	 <option value="11">11</option>
  	 <option value="12">12</option>	
</select>
<select name='startMin'>
	<option value="<?php echo $previous_data_array["startMin"]; ?>"><?php echo $previous_data_array["startMin"]; ?></option>
	 <option value=":00">:00</option>
 	 <option value=":15">:15</option>
  	 <option value=":30">:30</option>
 	 <option value=":45">:45</option>
</select>
<select name='startTime'>
	 <option value="<?php echo $previous_data_array["startCycle"]; ?>"><?php echo $previous_data_array["startCycle"]; ?></option>
	 <option value="AM">AM</option>
 	 <option value="PM">PM</option>
</select>
<br/>
End Time:<select name='endHour'>
	<option value="<?php echo $previous_data_array["endHour"]; ?>"><?php echo $previous_data_array["endHour"]; ?></option>
 	<option value="1">1</option>
  	 <option value="2">2</option>
  	 <option value="3">3</option>
  	 <option value="4">4</option>
  	 <option value="5">5</option>
	 <option value="6">6</option>
 	 <option value="7">7</option>
  	 <option value="8">8</option>
 	 <option value="9">9</option>
 	 <option value="10">10</option>
 	 <option value="11">11</option>
  	 <option value="12">12</option>
  	
</select>
<select name='endMin'>
		<option value="<?php echo $previous_data_array["endMin"]; ?>"><?php echo $previous_data_array["endMin"]; ?></option>
	 <option value=":00">:00</option>
 	 <option value=":15">:15</option>
  	 <option value=":30">:30</option>
 	 <option value=":45">:45</option>
</select>
<select name='endTime'>
	 <option value="<?php echo $previous_data_array["endCycle"]; ?>"><?php echo $previous_data_array["endCycle"]; ?></option>
	 <option value="AM">AM</option>
 	 <option value="PM">PM</option>
</select>



<!-- For adding the "other" option for manual input, use javascript to hide
or show text field when "other" is selected--> 

  <br/>
  Date (MM/DD/YYYY): <input type="text" name="date" id="date_input" value="<?php echo $previous_data_array["date"]; ?>"><br>
    Is home occupied?<select name='occupy'>
    	<option value=<?php echo $previous_data_array["occupied"]; ?>><?php echo $previous_data_array["tempOccupy"]; ?></option>
  		<option value=1>Yes</option>
  		<option value=0>No</option>
  </select>
  <br/>
  Select Showing Agent:
  	<select id="selectSAgent" name='SAgent'>
	    <?php
	    	foreach($formatted_info as $agent)
	    	{
	    		echo "<option value=\"".$agent."\">".$agent."</option>";
	    	}
	    ?>  
	</select>
  	<br>
  Customer First Name:<input type="text" name="fname" value="<?php echo $previous_data_array["fname"]; ?>" /><br>
  Customer Last Name:<input type="text" name="lname" value="<?php echo $previous_data_array["lname"]; ?>" /><br>
  Lock Box Code:<input type="text" name="code" value="<?php echo $previous_data_array["code"]; ?>" /><br>
  <input type="hidden" name="showing_id" value="<?php echo $_GET['showing_id'];?>">
  <input type="hidden" name="MLS" value="<?php echo $_GET['MLS']; ?>">
  <input type="hidden" name="original_SA" value= "<?php echo $previous_data_array["SA_id"];?>">
  <input type="submit" value="Submit" name="Submit" onClick = "valid()">
</form>

</body>
</html>