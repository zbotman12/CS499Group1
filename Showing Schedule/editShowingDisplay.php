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

include "../DBTransactor/DBTransactorFactory.php";

// END CUT from line 11 here. Remember to uncomment 'include' statements
$conn=DBTransactorFactory::build("Showings");
$tempArray= array("start_time", "end_time", "is_house_vacant", "customer_first_name", "customer_last_name", "lockbox_code", "showing_agent_name", "showing_agent_company");
$cond= array("showing_id"=> $_GET['showing_id']);  //We had $_GET['showing_id']

// Set Listings_MLS_number equal to whatever info we pass in instead of 1
if ($result = $conn->select($tempArray, $cond)) {
	foreach ($result as $key => $row){
		$fname = $row["customer_first_name"];
		$lname = $row["customer_last_name"];
		$occupied = $row["is_house_vacant"];
		$code = $row["lockbox_code"];
		$startTime = $row["start_time"];
		$endTime = $row["end_time"];
		$SAname=$row["showing_agent_name"];
		$SAcompany=$row['showing_agent_company'];
		if($occupied == 1)
		{
			$occupied = true;
			$tempOccupy="Yes";
		}
		else 
		{
			$occupied = false;
			$tempOccupy="No";
		}
		$year = substr($startTime, 0, 4);
		$month = substr($startTime, 5, 2);
	    $day = substr($startTime, 8, 2);
	    $startHour = (int)(substr($startTime, 11, 2));
	    $startMin = ":".substr($startTime, 14, 2);
	    $endHour = (int)(substr($endTime, 11, 2));
	    $endMin = ":".substr($endTime, 14, 2);
		$date = $month."/".$day."/".$year;
		if($startHour > 12)
		{
			$startHour = $startHour-12;
			$startCycle = "PM";
		}
		else 
		{
			$startCycle = "AM";
		}
		if($endHour > 12)
		{
			$endHour = $endHour-12;
			$endCycle = "PM";
		}
		else
		{
			$endCycle = "AM";
		}
	}
} else {
	echo $conn->error;
}


?>
<script src="dateFilter.js"></script>
</head>
<body>

<!-- action_page.php is a php file that handles the submitted input --> 
<form action="editShowingDataHandle.php" method="post">
Start Time:<select name='startHour'>
	<option value="<?php echo $startHour; ?>"><?php echo $startHour; ?></option>
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
	<option value="<?php echo $startMin; ?>"><?php echo $startMin; ?></option>
	 <option value=":00">:00</option>
 	 <option value=":15">:15</option>
  	 <option value=":30">:30</option>
 	 <option value=":45">:45</option>
</select>
<select name='startTime'>
	 <option value="<?php echo $startCycle; ?>"><?php echo $startCycle; ?></option>
	 <option value="AM">AM</option>
 	 <option value="PM">PM</option>
</select>
<br/>
End Time:<select name='endHour'>
	<option value="<?php echo $endHour; ?>"><?php echo $endHour; ?></option>
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
		<option value="<?php echo $endMin; ?>"><?php echo $endMin; ?></option>
	 <option value=":00">:00</option>
 	 <option value=":15">:15</option>
  	 <option value=":30">:30</option>
 	 <option value=":45">:45</option>
</select>
<select name='endTime'>
	 <option value="<?php echo $endCycle; ?>"><?php echo $endCycle; ?></option>
	 <option value="AM">AM</option>
 	 <option value="PM">PM</option>
</select>



<!-- For adding the "other" option for manual input, use javascript to hide
or show text field when "other" is selected--> 

  <br/>
  Date (MM/DD/YYYY): <input type="text" name="date" id="date_input" value="<?php echo $date; ?>"><br>
    Is home occupied?<select name='occupy'>
    	<option value="<?php echo $occupied; ?>"><?php echo $tempOccupy; ?></option>
  		<option value=true>Yes</option>
  		<option value=false>No</option>
  </select>
  <br/>
  	Showing Agent Name (First Last):<input type="text" name="SAname" value="<?php echo $SAname;?>"><br>
  	Company of Showing Agent:<input type="text" name="SAcompany" value="<?php echo $SAcompany?>"><br>
  Customer First Name:<input type="text" name="fname" value="<?php echo $fname; ?>" /><br>
  Customer Last Name:<input type="text" name="lname" value="<?php echo $lname; ?>" /><br>
  Lock Box Code:<input type="text" name="code" value="<?php echo $code; ?>" /><br>
  <input type="hidden" name="showing_id" value="<?php echo 1; ?>">
  <input type="hidden" name="MLS" value="<?php echo $_GET['MLS']; ?>">
  <input type="submit" value="Submit" name="Submit" onClick = "valid()">
</form>

</body>
</html>
