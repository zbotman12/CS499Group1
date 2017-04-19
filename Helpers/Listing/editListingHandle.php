<!--
    File: editListingDataHandle.php
    editListingDisplay data handler. Updates listing based on MLS number.
    Throws exception if MLS number is not in the database. 
-->

<?php

    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";

    //updateListingData();

    // ADD FILE NAME FOR RYANS LISTING FILE to redirect back to listings or showings
    //header('location: RYANS LISTING FILE NAME.php');

    //(MICHAEL) :: Must update this to use MLS number from listing selected.
    
    $listings=DBTransactorFactory::build("Listings");

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        try {

            //Turn MLS into numeric value before updating it. Get rid of spaces if any.
            $_GET['MLS'] = intval(str_replace(' ', '', $_GET['MLS']));

            // Change index of $_GET array to proper key.
            $_GET["MLS_number"] = $_GET['MLS'];

            // Delete old index
            unset($_GET['MLS']);
            
            //var_dump($_GET);

            // Update the listing.
            $listings->update($_GET, ["MLS_number" => $_GET['MLS_number']]);
            
            // Direct user to photoEditDisplay to edit pictures.
            header("location: ./../../Listing/photoEditDisplay.php?MLS=" . $_GET['MLS_number']);
        } catch(Exception $e) {
            echo $e->getMessage() . "<br\>";
        } 
    }
?>
