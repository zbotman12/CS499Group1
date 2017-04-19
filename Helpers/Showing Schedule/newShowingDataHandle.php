<?php
// ISSUE: Is_vacant ($occupy) is not display correctly.
include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/Mail/mail.php";

header('location: ../../Showing Schedule/showings.php?MLS=' . $_POST['MLS']);

handleShowingData();

/*
 * func: handleShowingData
 * param: N/A
 * desc: Handles formatting data submitted from newShowingDisplay.php
 * 		 form and creating a new showing based on that information. 
 * 		 Generates a feedback page for each showing.
 */
function handleShowingData(){
	// Try to establish connections to database
	try {
	  $feedback=DBTransactorFactory::build("Showing_Feedback");
      $showings=DBTransactorFactory::build("Showings");
      $agents=DBTransactorFactory::build("Agents");
      $agencies=DBTransactorFactory::build("Agencies");
	} catch (Exception $e) {
      echo $e->getMessage();
    }
    // Intialize variables to hold form data from newShowingDisplay.php
    // and set them to empty strings
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
		$MLS= intval($_POST['MLS']);
		$complete_info=test_input($_POST["SAgent"]);
	}

	error_log($startTime, 0);
	// Lines 42-62: Used to format and parse agent info.
	$parsed_info=parseShowingAgentData($complete_info);
	$SA_first_name= $parsed_info[1];
	$SA_last_name= $parsed_info[0];
	$SA_company_name= $parsed_info[2];
	//error_log($SA_first_name."-".$SA_last_name."-".$SA_company_name, 0);
	$temp_array= array("agency_id");
	$temp_array2= array("company_name"=>$SA_company_name);
	$confirmed_company= $agencies->select($temp_array, $temp_array2);
	//ob_start();
	//var_dump($confirmed_company);
	//$result_information = ob_get_clean();
	//error_log($result_information,0);
	$select_company=array_pop($confirmed_company);
	$temp_array3= array("agent_id");
	$temp_array4= array("first_name"=>$SA_first_name, "last_name"=>$SA_last_name, "Agencies_agency_id"=>$select_company["agency_id"]);
	//error_log("company_id ".$select_company["agency_id"], 0);
	$confirmed_SA_id=$agents->select($temp_array3, $temp_array4);
	$select_SA_id=array_pop($confirmed_SA_id);
	$SA_id=$select_SA_id["agent_id"];
	//error_log("agent id ".$SA_id,0);
	
	// Lines 66-67 are just used to set an hour time to 0-23 for formatting
	$startHour = fixTimeFormat($startTime, $startHour);
	$endHour = fixTimeFormat($endTime, $endHour);
	// lines 69-70 set up variables for str to date conversions
	$finalStartFormat = $date." ".$startHour.$startMin.":00";
	$finalEndFormat = $date." ".$endHour.$endMin.":00";
    
    $array = Array( "Listings_MLS_number"   => $MLS,
                    "start_time"            => "STR_TO_DATE('" . $finalStartFormat . "', '%m/%d/%Y %H:%i:%s')",
                    "end_time"              => "STR_TO_DATE('" . $finalEndFormat   . "', '%m/%d/%Y %H:%i:%s')",
                    "is_house_vacant"       => $occupy,
                    "customer_first_name"   => $fname,
                    "customer_last_name"    => $lname,
                    "lockbox_code"          => $code,
                    "showing_agent_id"    => intval($SA_id));
    
    try {
      $showings->insert($array); // add new showing
      $return_name= array("showing_id");
      $showing_info= $showings->select($return_name, $array);
      $showing_id=array_pop($showing_info);
      //error_log("break",0);
   	  // Create feedback info for the new showing
	  $feedback_array = Array("Showings_showing_id"=>$showing_id["showing_id"],
	  						  "customer_interest_level"=>0,
	  						  "showing_agent_experience_level"=>2,
	  						  "customer_price_opinion"=>null,
	  						  "additional_notes"=>null);
	  $msg = $feedback->insert($feedback_array);
	  error_log("did it work? ".$msg,0);

	  //var_dump($array);
	  //Send email before we leave newShowingDataHandle
  	  $mailer = new Mail;
  	  $array["start_time"] = $finalStartFormat;
  	  $array["end_time"]   = $finalEndFormat;

  	  $mailer->showing_mail($array);
      
      header('location: ../../Showing Schedule/showings.php?MLS=' . $_POST['MLS']);
     } catch (Exception $e) {
      echo $e->getMessage() . "<br/>";  
    }
}

// Parse out string containing agent info into array
function parseShowingAgentData($full_info)
{	//error_log($full_info, 0);
	$parsed_array = array(); // Lines 120-122: Parse out last name
	$pos=strrpos($full_info, ",");
	$tempStr=substr($full_info, 0, $pos);
	array_push($parsed_array, $tempStr);
	//error_log("$pos= ".$pos, 0);
	$pos2=strrpos($full_info, " of "); // Lines 125-127: Parse out first name
	$tempStr=substr($full_info, $pos+2, $pos2-$pos-2);
	array_push($parsed_array, $tempStr);
	//error_log("$pos2= ".$pos2, 0);
	$tempStr=substr($full_info, $pos2+4); // Lines 129-130: Parse out Company
	array_push($parsed_array, $tempStr);
	
	return $parsed_array; 
}

// Sets 1-12 hour to 0-23 hour format
function fixTimeFormat($temp, $temp2)
{
	if($temp=="AM" && $temp2==12)
	{
		$temp2=0;
	}

	if($temp == "PM")
	{
		$temp2 = $temp2+12;
		if($temp2==24)
		{
			$temp2=12;
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