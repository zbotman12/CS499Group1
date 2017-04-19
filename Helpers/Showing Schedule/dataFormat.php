<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";

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

function getFreeTime($agent, $day)
{
	$showings=DBTransactorFactory::build("Showings");
	$agents=DBTransactorFactory::build("Agents");
	$agencies=DBTransactorFactory::build("Agencies");

	$parsed_info=parseShowingAgentData($agent);
	$SA_first_name= $parsed_info[1];
	$SA_last_name= $parsed_info[0];
	$SA_company_name= $parsed_info[2];

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

	$finalDay= str_replace("/", "-", $day);
	$tempStr=substr($finalDay, 6, 4);
	$tempStr2= substr($finalDay, 0, 5);
	$finalStr= $tempStr."-".$tempStr2;

	

	$test= array("TIME(start_time) as Stime", "TIME(end_time) as Etime");
	$testCondAllTimes = array("DATE(start_time)"=>$finalStr, "Listings_MLS_number"=>$_POST['MLS']);
	$testCondAgentTimes= array("DATE(start_time)"=>$finalStr, "showing_agent_id"=>$SA_id);


	$resultsForAllTimes= $showings->select($test, $testCondAllTimes);
	$resultsForAgentTimes= $showings->select($test, $testCondAgentTimes);

	$resultsMerged= array_unique(array_merge($resultsForAllTimes,$resultsForAgentTimes), SORT_REGULAR);


	$hour_array= array("00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23");
	$add_array= array();
	$minute_array= array(":00", ":15", ":30", ":45");
	$key_array=array();

	for($i=0; $i<24; $i++)
	{
		for($j=0; $j<4;$j++)
		{
			$tempHM= $hour_array[$i].$minute_array[$j];
			$add_array[$tempHM]=0;
			array_push($key_array, $tempHM);
		}
	}

	foreach($resultsMerged as $timeSlot)
	{
		$STime = substr($timeSlot["Stime"], 0, 5);
		$ETime= substr($timeSlot["Etime"], 0, 5);

		$searchTime= array_search($STime, $key_array);
		
		$add_array[$key_array[$searchTime]]=1;
		
		$increment = 1;
		while(true)
		{
			//error_log($key_array[$searchTime+$increment], 0);
			if($key_array[$searchTime+$increment]!=$ETime)
			{
				$add_array[$key_array[$searchTime+$increment]]=2;
			}
			else if($key_array[$searchTime+$increment]==$ETime)
			{
				$add_array[$key_array[$searchTime+$increment]]=3;
				break;
			}
			$increment++;
		}
	}
	return $add_array;
	}

function getFreeTimeUpdate($begin, $end, $agent, $day)
{
	$showings=DBTransactorFactory::build("Showings");
	$agents=DBTransactorFactory::build("Agents");
	$agencies=DBTransactorFactory::build("Agencies");

	$parsed_info=parseShowingAgentData($agent);
	$SA_first_name= $parsed_info[1];
	$SA_last_name= $parsed_info[0];
	$SA_company_name= $parsed_info[2];

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

	$finalDay= str_replace("/", "-", $day);
	$tempStr=substr($finalDay, 6, 4);
	$tempStr2= substr($finalDay, 0, 5);
	$finalStr= $tempStr."-".$tempStr2;

	

	$test= array("TIME(start_time) as Stime", "TIME(end_time) as Etime");
	$testCondAllTimes = array("DATE(start_time)"=>$finalStr, "Listings_MLS_number"=>$_POST['MLS']);
	$testCondAgentTimes= array("DATE(start_time)"=>$finalStr, "showing_agent_id"=>$SA_id);


	$resultsForAllTimes= $showings->select($test, $testCondAllTimes);
	$resultsForAgentTimes= $showings->select($test, $testCondAgentTimes);

	$resultsMerged= array_unique(array_merge($resultsForAllTimes,$resultsForAgentTimes), SORT_REGULAR);


	$hour_array= array("00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23");
	$add_array= array();
	$minute_array= array(":00", ":15", ":30", ":45");
	$key_array=array();

	for($i=0; $i<24; $i++)
	{
		for($j=0; $j<4;$j++)
		{
			$tempHM= $hour_array[$i].$minute_array[$j];
			$add_array[$tempHM]=0;
			array_push($key_array, $tempHM);
		}
	}


	if(strlen($begin)==7)
	{
		$parHour = substr($begin, 0,2);
		$parMin= substr($begin, 2, 3);
		$parCycle= substr($begin, 5, 2);
	}
	else
	{
		$parHour = substr($begin, 0,1);
		$parMin= substr($begin, 1, 3);
		$parCycle= substr($begin, 4, 2);
	}	

	if($parCycle=="PM")
	{
		$parHour=intval($parHour)+12;
		if($parHour==24)
		{
			$parHour="12";
		}
	}

	if(intval($parHour)<10)
	{
		$parHour="0".$parHour;
	}
	if($parCycle=="AM" && intval($parHour)==12)
	{
		$parHour="00";
	}

	$begin=$parHour.$parMin;

	if(strlen($end)==7)
	{
		$parHour = substr($end, 0,2);
		$parMin= substr($end, 2, 3);
		$parCycle= substr($end, 5, 2);
	}
	else
	{
		$parHour = substr($end, 0,1);
		$parMin= substr($end, 1, 3);
		$parCycle= substr($end, 4, 2);
	}	


	if($parCycle=="PM")
	{
		$parHour=intval($parHour)+12;
		if($parHour==24)
		{
			$parHour="12";
		}
	}

	if(intval($parHour)<10)
	{
		$parHour="0".$parHour;
	}
	if($parCycle=="AM" && intval($parHour)==12)
	{
		$parHour="00";
	}

	$end=$parHour.$parMin;




	foreach($resultsMerged as $timeSlot)
	{
		$STime = substr($timeSlot["Stime"], 0, 5);
		$ETime= substr($timeSlot["Etime"], 0, 5);

		if($STime!=$begin && $ETime!=$end)
		{
		$searchTime= array_search($STime, $key_array);
		
		$add_array[$key_array[$searchTime]]=1;
		
		$increment = 1;
		while(true)
		{
			//error_log($key_array[$searchTime+$increment], 0);
			if($key_array[$searchTime+$increment]!=$ETime)
			{
				$add_array[$key_array[$searchTime+$increment]]=2;
			}
			else if($key_array[$searchTime+$increment]==$ETime)
			{
				$add_array[$key_array[$searchTime+$increment]]=3;
				break;
			}
			$increment++;
		}
		}
		else
		{
			error_log($STime." ".$ETime, 0);
		}
	}
	return $add_array;
	}

function getDefinedAgentInfo($SA_id)
{
	$agencies=DBTransactorFactory::build("Agencies");
	$agents=DBTransactorFactory::build("Agents");
	
	$cond= array("agent_id"=>$SA_id);
	$temp_array= array("first_name", "last_name", "Agencies_agency_id");
	$agent_info=$agents->select_where_not($temp_array, $cond);
	
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

function getCompanyInfo(){
	
	$company=DBTransactorFactory::build("Agencies");
	$tempCond = array("company_name");
	$tempS = array();

	$company_array=$company->select($tempName, $tempS);
	$final_array= array();
	foreach($company_array as $agency_id => $com)
	{
		array_push($final_array, $com[$agency_id]["company_name"]);
	}

	/*ob_start();
			var_dump($final_array);
			$result_information = ob_get_clean();
			error_log($result_information,0);*/
	return $final_array;
}

function getPreviousData($id){
	$conn=DBTransactorFactory::build("Showings");
	$return_array= array();
	$tempArray= array("start_time", "end_time", "is_house_vacant", "customer_first_name", "customer_last_name", "lockbox_code", "showing_agent_id");
	$cond= array("showing_id"=> $id);  //We had $_GET['showing_id']
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
				$occupied = 1;
				$tempOccupy="Yes";
			}
			else
			{
				$occupied = 0;
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
			if($startHour==12)
			{
				$startCycle="PM";
			}else{
			if($startHour > 12)
			{
				$startHour = $startHour-12;
				$startCycle = "PM";
			}
			else
			{
				$startCycle = "AM";
			}}

			if($endHour==12)
			{
				$endCycle="PM";
			}
			else
			{
			if($endHour > 12)
			{
				$endHour = $endHour-12;
				$endCycle = "PM";
			}
			else
			{
				$endCycle = "AM";
			}}
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

	
	
	




	
		
