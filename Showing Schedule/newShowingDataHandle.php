<?php
// ISSUE: Line 31. Remove hardcoded $MLS.
// ISSUE: Check for duplicate entries in database
header('location: ./../showings.php?MLS=' . $_POST['MLS']);
//include './../sessioncheck.php"; -- Possible remove this. talk to Michael
include "../DBTransactor/DBTransactorFactory.php";

handleShowingData();
// ADD FILE NAME FOR RYANS LISTING FILE into header to redirect back to listings

function handleShowingData(){
	
	$showings=DBTransactorFactory::build("Showings");
	
	$startHour=$startMin=$startTime=$endHour=$endMin=$endTime=$date=$occupy=
	$fname=$lname=$code=$MLS="";

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
		$MLS= $_POST['MLS'];
		$SAname=test_input($_POST["SAname"]);
		$SAcompany=test_input($_POST["SAcompany"]);
	}

	// Lines 37,38 are just used to set an hour time to 0-23 for formatting
	$startHour = fixTimeFormat($startTime, $startHour);
	$endHour = fixTimeFormat($endTime, $endHour);

	// lines 41,42 set up variables for str to date conversions
	$finalStartFormat = $date." ".$startHour.$startMin.":00";
	$finalEndFormat = $date." ".$endHour.$endMin.":00";
    
    //Debug
    //var_dump($finalStartFormat);
    //echo "<br/>";
    //var_dump($finalEndFormat);
    //echo "<br/>";
    var_dump($occupy); 
    $array = Array( "Listings_MLS_number"   => $MLS,
                    "start_time"            => "STR_TO_DATE('" . $finalStartFormat . "', '%m/%d/%Y %H:%i:%s')",
                    "end_time"              => "STR_TO_DATE('" . $finalEndFormat   . "', '%m/%d/%Y %H:%i:%s')",
                    "is_house_vacant"       => $occupy,
                    "customer_first_name"   => $fname,
                    "customer_last_name"    => $lname,
                    "lockbox_code"          => $code,
                    "showing_agent_name"    => $SAname,
                    "showing_agent_company" => $SAcompany );

    //var_dump($array);
	//$temp_array= array("Listing_MLS_number"=>$MLS, "Agents_showing_agent_id"=>$AID, "start_time"=>(STR_TO_DATE('$finalStartFormat','%m/%d/%Y %H:%i:%s')),
	//	"end_time"=>(STR_TO_DATE('$finalEndFormat', '%m/%d/%Y %H:%i:%s')), "is_house_vacant"=>$occupy, "customer_last_name"=>$fname, "customer_first_name"=>$lname, 
	//	"lockbox_code"=>$code, "showing_agent_name"=>$SAname, "showing_agent_company"=>$SAcompany);
	
    /*$sql = "INSERT INTO Showings(Listings_MLS_number, start_time, end_time,is_house_vacant, customer_first_name, customer_last_name, lockbox_code, showing_agent_name, showing_agent_company)
	VALUES ('$MLS', STR_TO_DATE('$finalStartFormat','%m/%d/%Y %H:%i:%s'), STR_TO_DATE('$finalEndFormat', '%m/%d/%Y %H:%i:%s'), '$occupy',
	'$fname', '$lname', '$code', '$SAname', '$SAcompany')"; */

    try {
      //$showings->insertPlus($sql);
	  $showings->insert($array);

    } catch (Exception $e) {
      echo $e->getMessage() . "<br/>";  
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
