<!DOCTYPE html>
<!-- ISSUES: Line 70-71 True and False values printed as string. Need to handle this.-->
<?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/Showing Schedule/dataFormat.php";
?>

<html>
<head>	
<link
	href=formattingFileShowingSchedule.css
	type="text/css"
	rel="stylesheet">
<!-- <meta charset="UTF-8"> -->
<title></title>
<script src="/js/dateFilter.js">
</script>
</head>
<body>
<!-- action_page.php is a php file that handles the submitted input --> 
<form name="scheduleForm" action="/Helpers/Showing Schedule/newShowingDataHandle.php" method="post">
	Start Time:<select name='startHour'>
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
	    <option value=":00">:00</option>
 	    <option value=":15">:15</option>
  	    <option value=":30">:30</option>
 	    <option value=":45">:45</option>
	</select>
	<select name='startTime'>
	    <option value="AM">AM</option>
 	    <option value="PM">PM</option>
	</select>
	<br/>
	End Time:<select name='endHour'>
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
	    <option value=":00">:00</option>
 	    <option value=":15">:15</option>
  	    <option value=":30">:30</option>
 	    <option value=":45">:45</option>
	</select>
	<select name='endTime'>
	    <option value="AM">AM</option>
 	    <option value="PM">PM</option>
	</select>
<!-- For adding the "other" option for manual input, use javascript to hide
or show text field when "other" is selected--> 
	<br/>
  	Date (MM/DD/YYYY): <input type="text" name="date" id="date_input" required><br>
    Is home occupied?<select name='occupy'>
  		<option value=true>Yes</option>
  		<option value=false>No</option>
  	</select>
  	<br/>
    <!-- possibly auto fill the name and company with listing agent info -->
  	Select Showing Agent:
  	<select id="selectSAgent" name='SAgent'>
	    <?php
	    	foreach($formatted_info as $agent)
	    	{
	    		echo "<option value=\"".$agent."\">".$agent."</option>";
	    	}
	    ?>  
	</select><br>
  	Customer First Name:<input type="text" name="fname"><br>
  	Customer Last Name:<input type="text" name="lname"><br>
  	Lock Box Code:<input type="text" name="code"><br>
  	<input type="hidden" name="MLS" value="<?php echo $_GET['MLS']; ?>">
  	<input type="submit" value="Submit" name="Submit" onClick="return isValid()"/>
</form>
</body>
</html>