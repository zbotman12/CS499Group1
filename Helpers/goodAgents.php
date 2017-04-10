<?php
	/*
		Prevent agents from accessing other agent's edit page for fair play among ParagonMLS services.
		This file must be included in every page where agents must edit information. 
	*/
    // Check included files.
    /*$included_files = get_included_files();
    
    $isIncluded = false;

    //var_dump($included_files);
    foreach($included_files as $file) {
        if (strpos($file, "editShowingDisplay.php") !== false) {
            $isIncluded = true;
        }
    }

    //Check if DBTransactorFactory is included.
    if(!$isIncluded) {
        include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";
    } */

	//include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/Showing Schedule/dataFormat.php";
    goodAgent();
    
    function goodAgent() {
    //include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";
    //use DBTransactorFactory as Transactor;
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
	$showings = $showingsTable->select(["showing_agent_id"], ["showing_id" => $sID]);
    //var_dump($showings);

	/********************************************************************************************** 
		Check Listings edit information
	***********************************************************************************************/
	
	//Check edit listing display page.
	if (strpos($_SERVER['REQUEST_URI'], '/Listing/editListingDisplay.php') !== false) {

		if (array_key_exists($MLS, $listings)) {
			if ($listings[$MLS]["Agents_listing_agent_id"] == $_SESSION['number'] ) {
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
	if (strpos($_SERVER['REQUEST_URI'], '/Listing/photoEditDisplay.php') !== false) {
		if (array_key_exists($MLS, $listings)) {
			if ($listings[$MLS]["Agents_listing_agent_id"] == $_SESSION['number'] ) {
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
	//Check Showings. Only showing agent can edit i
   // error_log("Just about to call editshowing display if");
    //error_log($_SERVER['REQUEST_URI']);
	if (strpos($_SERVER['REQUEST_URI'], "/Showing%20Schedule/editShowingDisplay.php") !== false) {
		if (array_key_exists($sID, $showings)) {
            //error_log("Im in the function");
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

	//Check Showings. Only showing agent can edit 
	if (strpos($_SERVER['REQUEST_URI'], "/Showing%20Schedule/deleteShowingHandle.php") !== false) {
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
	}	}

?>
