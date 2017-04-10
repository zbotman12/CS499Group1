<?php
	/*
		Prevent agents from accessing other agent's edit page for fair play among ParagonMLS services.
		This file must be included in every page where agents must edit information. 
	*/

    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/Showing Schedule/dataFormat.php";

    $listingsTable = DBTransactorFactory::build("Listings");
  	$agentsTable   = DBTransactorFactory::build("Agents");

	$MLS = null;
	$sID = null;
	$mlsAgentID     = null;
	$currentAgentID = $_SESSION['number']; 
    $MLSAgentAgency = null;
    $sessionAgency  = null;

    //Get current MLS from url if set.
	if (isset($_GET['MLS'])) {
		$MLS = intval($_GET['MLS']);
	}
	
	//Get showing ID from URL if set.
	if (isset($_GET['showing_id'])) {
		$sID = intval($_GET['showing_id']);
	}
    
	//Get listing using MLS number and mls agent id. 
    $listings = $listingsTable->select(["Agents_listing_agent_id"], ["MLS_number" => $MLS]);
    $mlsAgentID = $listings[$MLS]["Agents_listing_agent_id"];

    //Get agency_id information of current agent.
    $current_agent = $agentsTable->select(["Agencies_agency_id"], ["agent_id" => $currentAgentID]);

    //Get agency_id information of MLS agent.
    $mls_agent = $agentsTable->select(["Agencies_agency_id"], ["agent_id" => $mlsAgentID]);

    //Set variables for agencies
	$sessionAgency  = $current_agent[$currentAgentID]["Agencies_agency_id"];
	$MLSAgentAgency = $mls_agent[$mlsAgentID]["Agencies_agency_id"];

	/********************************************************************************************** 
		Check Listings edit information
	***********************************************************************************************/
	
	//Check edit listing display page.
	if ((strpos($_SERVER['REQUEST_URI'], '/Listing/editListingDisplay.php') !== false) || (strpos($_SERVER['REQUEST_URI'], '/Listing/photoEditDisplay.php') !== false))  {

		if (array_key_exists($MLS, $listings)) {
			if ($sessionAgency == $MLSAgentAgency) {
				//Don't do anything.
			}
			else {
				header("location: /index.php");
				exit();
			}
		}
		else {
			header("location: /index.php");
			exit();
		}
	}
	
	/********************************************************************************************** 
		Check Showings edit information. Only showing agent or listing agent can edit.
	***********************************************************************************************/
	//Check Showings. 
	if ((strpos($_SERVER['REQUEST_URI'], "/Showing%20Schedule/editShowingDisplay.php") !== false) || (strpos($_SERVER['REQUEST_URI'], "/Showing%20Schedule/deleteShowingHandle.php") !== false))  {
		$showingsTable = DBTransactorFactory::build("Showings");

		//Get Showing information using MLS number. 
		$showings = $showingsTable->select(["showing_agent_id"], ["showing_id" => $sID]);

		if (array_key_exists($sID, $showings)) {
			if (intval($showings[$sID]["showing_agent_id"]) == $_SESSION['number'] || intval($listings[$MLS]["Agents_listing_agent_id"]) == $_SESSION['number']) {
				//Don't do anything.
			}
			else {
				header("location: /index.php");
				exit();
			}
		}
		else {
			header("location: /index.php");
			exit();
		}
	}

?>
