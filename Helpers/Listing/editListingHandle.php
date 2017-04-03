<!--
    File: editListingDataHandle.php
    editListingDisplay data handler. Updates listing based on MLS number.
    Throws exception if MLS number is not in the database. 
-->

<?php

    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessioncheck.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";

    //updateListingData();

    // ADD FILE NAME FOR RYANS LISTING FILE to redirect back to listings or showings
    //header('location: RYANS LISTING FILE NAME.php');

    //(MICHAEL) :: Must update this to use MLS number from listing selected.
    
    $listings=DBTransactorFactory::build("Listings");

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        try {
            $listings->update($_GET, ["MLS_number" => $_GET['MLS']]);
            $v = $_GET['MLS'];
            $y = intval($v);
            header("location: ./../../Listing/photoEditDisplay.php?MLS=$y");
        } catch(Exception $e) {
            echo $e->getMessage() . "<br\>";
        }
        
    }
?>
