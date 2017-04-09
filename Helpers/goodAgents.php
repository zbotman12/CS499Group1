<?php
	/*
		Prevent agents from accessing other agent's edit page for fair play among ParagonMLS services.
		This file must be included in every page where agents must edit information. 
	*/
	
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";

    $listingsTable = DBTransactorFactory::build("Listings");
	$showingsTable = DBTransactorFactory::build("Showings");
	
	$MLS = null;
	$sID = null;
	
	//Get current MLS from url if set.
	if (isset($_GET['MLS'])) {
		$MLS = intval($_GET['MLS']);
	}
	
	//Get showing ID from URL if set.
	if (isset($_GET['showing_id'])) {
		$sID = intval($_GET['showing_id']);
	}
	
	//Get listing using MLS number. 
    $listings = $listingsTable->select(["Agents_listing_agent_id"], ["MLS_number" => $MLS]);

	//Get Showing information using MLS number. 
	$showings = $showingsTable->select(["showing_agent_id"], ["showing_id"] => $sID);
	
	/********************************************************************************************** 
		Check Listings edit information
	***********************************************************************************************/
	
	//Check edit listing display page.
	if (strpos($_SERVER['QUERY_STRING'], '/Listing/editListingDisplay.php') !== false) {
		if (array_key_exists($MLS, $listings)) {
			if ($alllistings[$MLS]["Agents_listing_agent_id"] == $_SESSION['number'] ) {
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
	
	//Check edit photo display page.
	if (strpos($_SERVER['QUERY_STRING'], '/Listing/photoEditDisplay.php') !== false) {
		if (array_key_exists($MLS, $listings)) {
			if ($alllistings[$MLS]["Agents_listing_agent_id"] == $_SESSION['number'] ) {
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
		Check Showings edit information. Only showing agent can edit this.
	***********************************************************************************************/
	//Check Showings. Only showing agent can edit 
	if (strpos($_SERVER['QUERY_STRING'], "/Showing Schedule/editShowingDisplay.php") !== false) {
		if (array_key_exists($sID, $showings)) {
			if ($showings[$sID]["showing_agent_id"] == $_SESSION['number'] ) {
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

	//Check Showings. Only showing agent can edit 
	if (strpos($_SERVER['QUERY_STRING'], "/Showing Schedule/deleteShowingHandle.php") !== false) {
		if (array_key_exists($sID, $showings)) {
			if ($showings[$sID]["showing_agent_id"] == $_SESSION['number'] ) {
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
