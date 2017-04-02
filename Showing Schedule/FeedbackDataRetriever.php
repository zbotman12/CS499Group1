<?php
	include "DBTransactor/DBTransactorFactory.php";
	
	
	function get_FeedbackInfo()
	{
	$conn=DBTransactorFactory::build("Showings");
	$conn2=DBTransactorFactory::build("Showing_Feedback");
	$conn3=DBTransactorFactory::build("Agents");
	
	// Pull data from Showing Feedback
	$tempArray= array("customer_interest_level", "showing_agent_experience_level","customer_price_opinion","additional_notes");
	$cond= array("Showings_showing_id"=>$_GET['showing_id']);
	if ($result = $conn->select($tempArray, $cond)) {
		while ($row = $result->fetch_array()){
			$customer_interest = $row["customer_interest_level"];
			$showing_agent_exp = $row["showing_agent_experience_level"];
			$customer_price = $row["customer_price_opinion"];
			$addtional_notes = $row["additional_notes"];
		}
	}
	
	//Pull data from Showing
	$tempArray= array("is_house_vacant", "customer_first_name", "customer_last_name", "lockbox_code", 
	"showing_agent_id");
	$cond= array("showing_id"=>$_GET['showing_id']);
	if ($result = $conn2->select($tempArray, $cond)) {
		while ($row = $result->fetch_array()){
			$vacant = $row["is_house_vacant"];
			$customer_first_name = $row["customer_first_name"];
			$customer_last_name = $row["customer_last_name"];
			$code = $row["lockbox_code"];
			$showing_agent_id=$row["showing_agent_id"];
		}
	}
	
	//Pull data from Agents
	$tempArray= array("first_name", "last_name", "email", "phone_number");
	$cond= array("agent_id"=>$showing_agent_id);
	if ($result = $conn3->select($tempArray, $cond)) {
		while ($row = $result->fetch_array()){
			$first_name = $row["first_name"];
			$last_name = $row["last_name"];
			$email = $row["email"];
			$phone= $row["phone_number"];
		}
	}
	

	
	$dataArray=array($customer_interest, $showing_agent_exp, $customer_price, $additional_notes,
			$vacant, $customer_first_name, $customer_last_name, $code, $showing_agent_id,
			$first_name, $last_name, $email, $phone);
	
	mysql_close($conn);
	mysql_close($conn2);
	mysql_close($conn3);
	
	return $dataArray;
	}
	