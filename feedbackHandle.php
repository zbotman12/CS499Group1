<?php
header('location: ./../showings.php?MLS=' . $_POST['MLS']);
include "../DBTransactor/DBTransactorFactory.php";
handleFeedbackData();


function handleFeedbackData()
{
	$feedback=DBTransactorFactory::build("Showing_Feedback");
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$interest = test_input($_POST["interest"]);
		$experience = test_input($_POST["experience"]);
		$opinion = test_input($_POST["opinion"]);
		$additional = test_input($_POST["additional"]);
		$showing_id = $_POST["showing_id"];
	
	}
	
	$feedback_array= array(
			"customer_interest_level"=>$interest,
			"showing_agent_experience"=>$experience,
			"customer_price_opinion"=>$opinion,
			"additional_notes"=>$additional);
	$feedback_cond= array("Showings_showing_id"=>$showing_id);
	$feedback=update($feedback_array, $feedback_cond);
	header('location: ./../showings.php?MLS=' . $_POST['MLS']);
}


// test for proper input
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}