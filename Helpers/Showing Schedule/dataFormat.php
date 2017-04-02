<?php
include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";

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

function push_into_associative_array($tempArray, $value, $key)
{
	$tempArray[$key]=$value;
	return $tempArray;
}



	
	
	




	
	