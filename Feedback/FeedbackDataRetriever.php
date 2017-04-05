<?php
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
	include "../DBTransactor/DBTransactorFactory.php";
	
	
	function get_FeedbackInfo()
	{
	$conn=DBTransactorFactory::build("Showings");
	$conn2=DBTransactorFactory::build("Showing_Feedback");
	$conn3=DBTransactorFactory::build("Agents");
	
	// Pull data from Showing Feedback
	$tempArray= array("customer_interest_level", "showing_agent_experience_level","customer_price_opinion","additional_notes");
	$cond= array("Showings_showing_id"=>$_GET['showing_id']);
	$result = $conn2->select($tempArray, $cond);
	ob_start();
	var_dump($result);
	$result_information = ob_get_clean();
	error_log($result_information,0);
	$row = array_pop($result);
	$customer_interest = $row["customer_interest_level"];
	$showing_agent_exp = $row["showing_agent_experience_level"];
	$customer_price = $row["customer_price_opinion"];
	$additional_notes = $row["additional_notes"];
		
	
	//Pull data from Showing
	$tempArray= array("is_house_vacant", "customer_first_name", "customer_last_name", "lockbox_code", 
	"showing_agent_id");
	$cond= array("showing_id"=>$_GET['showing_id']);
	$result = $conn->select($tempArray, $cond);
	$row = array_pop($result);
	$vacant = $row["is_house_vacant"];
	$customer_first_name = $row["customer_first_name"];
	$customer_last_name = $row["customer_last_name"];
	$code = $row["lockbox_code"];
	$showing_agent_id=$row["showing_agent_id"];
		
	//Pull data from Agents
	$tempArray= array("first_name", "last_name", "email", "phone_number");
	$cond= array("agent_id"=>$showing_agent_id);
	$result = $conn3->select($tempArray, $cond);
	$row = array_pop($result);
	$first_name = $row["first_name"];
	$last_name = $row["last_name"];
	$email = $row["email"];
	$phone= $row["phone_number"];
	

	$dataArray=array($customer_interest, $showing_agent_exp, $customer_price, $additional_notes,
			$vacant, $customer_first_name, $customer_last_name, $code, $showing_agent_id,
			$first_name, $last_name, $email, $phone);
	
	/*ob_start();
	var_dump($dataArray);
	$result_information = ob_get_clean();
	error_log($result_information,0);
	*/
	return $dataArray;
	}
	