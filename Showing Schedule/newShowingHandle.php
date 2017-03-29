<?php
//include "./../dbconnect.php";
//include './../sessioncheck.php";
	
handleShowingData();
// ADD FILE NAME FOR RYANS LISTING FILE
//header('location: RYANS LISTING FILE NAME.php');

function handleShowingData(){
	//Cut line 9-24 and uncomment above 'include' statements when adding to server
$DB_LOCATION = 'localhost:8889';  //Server URL
$DB_USERNAME = 'root';//'nick';       //Database access username use 'root' for testing
//nick is our username
$DB_PW       = 'root';//diliberti';  //Database access password use 'root' for testing
// diliberti is our password
$DB_NAME     = 'showing';//'ParagonMLS';    //Name of database to be accessed use 'test' for testing

$conn = new mysqli($DB_LOCATION, $DB_USERNAME, $DB_PW, $DB_NAME);

if ($conn->connect_error) {
	echo "Connection failed: " . $conn->connect_error;
} else {
	echo "Connection successful<br/>";
}
// END CUT from line 9 here. Remember to uncomment 'include' statements
	$startHour=$startMin=$startTime=$endHour=$endMin=$endTime=$date=$occupy=
	$fname=$lname=$code="";
		
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$startHour = test_input($_POST["startHour"]);
		$startMin = test_input($_POST["startMin"]);
		$startTime = test_input($_POST["startTime"]);
		$endHour = test_input($_POST["endHour"]);
		$endMin = test_input($_POST["endMin"]);
		$endTime = test_input($_POST["endTime"]);
		$date = test_input($_POST["date"]);
		$occupy = $_POST["occupy"];
		$fname = test_input($_POST["fname"]);
		$lname = test_input($_POST["lname"]);
		$code = test_input($_POST["code"]);
	}
	
	// Lines 37,38 are just used to set an hour time to 0-23 for formatting
	$startHour = fixTimeFormat($startTime, $startHour);
	$endHour = fixTimeFormat($endTime, $endHour);

	// lines 41,42 set up variables for str to date conversions
	$finalStartFormat = $date." ".$startHour.$startMin.":00";
	$finalEndFormat = $date." ".$endHour.$endMin.":00";

// I am assuming that listing info will be passed into this for Listing_MLS_number
// and Agents_showing_agent_id. Can just cut these two test variables after
// proper data is assigned in INSERT statement
	$tempMLS = 1;
	$tempAgentId = 2;
	
	// After this is put on the server, switch table name to Showings from test2
	$sql = "INSERT INTO test2(Listings_MLS_number, Agents_showing_agent_id, start_time, end_time, is_house_vacant, customer_first_name, customer_last_name, lockbox_code)
	VALUES ('$tempMLS', '$tempAgentId', STR_TO_DATE('$finalStartFormat','%m/%d/%Y %H:%i:%s'), STR_TO_DATE('$finalEndFormat', '%m/%d/%Y %H:%i:%s'), '$occupy',
	'$fname', '$lname', '$code')";
	
	if (mysqli_query($conn, $sql)) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}

// Sets 1-12 hour to 0-23 hour format
function fixTimeFormat($temp, $temp2)
{
	if($temp == "PM")
	{
		$temp2 = $temp2+12;
		if($temp2 == 24)
		{
			$temp2 = 00;
		}	
	}
	return $temp2;
}

// test for proper input
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>