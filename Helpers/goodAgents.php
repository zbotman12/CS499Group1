<?php
	/*
		Prevent agents from accessing other agent's edit page for fair play among ParagonMLS services.
		This file must be included in every page where agents must edit information. 
	*/
	
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";

    $listingsTable = DBTransactorFactory::build("Listings");

    //Get all listings. All listings indexed by MLS number.
    $sel = ["MLS_number", "Agents_listing_agent_id"];
    $allListings = $listingsTable->select($sel, []);

    //Get current MLS from url.
    $MLS = $_GET['MLS'];
    
    if (array_key_exists($MLS, $allListings)) {
    	if ($allListings[$MLS]["Agents_listing_agent_id"] == $_SESSION['number'] ) {
    		//Don't do anything.
    	}
    	else {
			header("location: " . $_SERVER['DOCUMENT_ROOT'] . "index.php");
			exit();
    	}
	} else {
		header("location: " . $_SERVER['DOCUMENT_ROOT'] . "index.php");
		exit();
	}
?>