<?php
include "../DBTransactor/DBTransactorFactory.php";

function getAgentInfo()
{
	$agencies=DBTransactorFactory::build("Agencies");
	$agents=DBTransactorFactory::build("Agents");
	
	$empty_cond= array();
	$temp_array= array("first_name", "last_name", "Agencies_agency_id");
	$agent_info=$agents->select_with_order($temp_array, $empty_cond);

	$formatted_info= array();
	$temp_array= array("company_name");

	foreach($agent_info as $agent)
	{
		$temp_var = array("agency_id"=>$agent["Agencies_agency_id"]);
		$temp_name= $agencies->select($temp_array, $temp_var);
		$temp_total_info=$agent["last_name"].", ".$agent["first_name"]." of ".$temp_name[$agent["Agencies_agency_id"]]["company_name"];
		array_push($formatted_info, $temp_total_info);
	}
	
	return $formatted_info;
}

function getDefinedAgentInfo($SA_id)
{
	$agencies=DBTransactorFactory::build("Agencies");
	$agents=DBTransactorFactory::build("Agents");
	
	$cond= array("agent_id"=>$SA_id);
	$temp_array= array("first_name", "last_name", "Agencies_agency_id");
	$agent_info=$agents->select_where_not($temp_array, $cond);
	
	/*ob_start();
	var_dump($agent_info);
	$result_information = ob_get_clean();
	error_log($result_information,0);*/
	
	$formatted_info= array();
	$temp_array2= array("company_name");
	
	foreach($agent_info as $agent)
	{
		$temp_var = array("agency_id"=>$agent["Agencies_agency_id"]);
		$temp_name= $agencies->select($temp_array2, $temp_var);
		$temp_total_info=$agent["last_name"].", ".$agent["first_name"]." of ".$temp_name[$agent["Agencies_agency_id"]]["company_name"];
		array_push($formatted_info, $temp_total_info);
	}
	
	$agent_info=$agents->select($temp_array, $cond);
	$agent=array_pop($agent_info);
	$temp_var = array("agency_id"=>$agent["Agencies_agency_id"]);
	$temp_name= $agencies->select($temp_array2, $temp_var);
	$temp_company=array_pop($temp_name);
	$temp_total_info=$agent["last_name"].", ".$agent["first_name"]." of ".$temp_company["company_name"];
	array_unshift($formatted_info, $temp_total_info);
	
	return $formatted_info;
}

function getPreviousData(){
	$conn=DBTransactorFactory::build("Showings");
	$return_array= array();
	$tempArray= array("start_time", "end_time", "is_house_vacant", "customer_first_name", "customer_last_name", "lockbox_code", "showing_agent_id");
	$cond= array("showing_id"=> $_GET['showing_id']);  //We had $_GET['showing_id']
	// Set Listings_MLS_number equal to whatever info we pass in instead of 1
	if ($result = $conn->select($tempArray, $cond)) {
		foreach ($result as $key => $row){
			$return_array["fname"] = $row["customer_first_name"];
			$return_array["lname"] = $row["customer_last_name"];
			$occupied = $row["is_house_vacant"];
			$return_array["code"] = $row["lockbox_code"];
			$startTime = $row["start_time"];
			$endTime = $row["end_time"];
			$return_array["SA_id"]=$row["showing_agent_id"];
				
				
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
			
			$return_array["occupied"]=$occupied;
			$return_array["tempOccupy"]=$tempOccupy;
			$year = substr($startTime, 0, 4);
			$month = substr($startTime, 5, 2);
			$day = substr($startTime, 8, 2);
			$startHour = (int)(substr($startTime, 11, 2));
			$return_array["startMin"] = ":".substr($startTime, 14, 2);
			$endHour = (int)(substr($endTime, 11, 2));
			$return_array["endMin"] = ":".substr($endTime, 14, 2);
			$return_array["date"] = $month."/".$day."/".$year;
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
			$return_array["startHour"]=$startHour;
			$return_array["endHour"]=$endHour;
			$return_array["startCycle"]=$startCycle;
			$return_array["endCycle"]=$endCycle;
			
			/*ob_start();
			var_dump($return_array);
			$result_information = ob_get_clean();
			error_log($result_information,0);
			*/
			return $return_array;
		}
	} else {
		echo $conn->error;

	}
	return $return_array;
}


function push_into_associative_array($tempArray, $value, $key)
{
	$tempArray[$key]=$value;
	return $tempArray;
}




	
	
	




	
	