<?php

    include "./../sessioncheck.php";
    include "../DBTransactor/DBTransactorFactory.php";

    handleListingData();

    // ADD FILE NAME FOR RYANS LISTING FILE to redirect back to listings or showings
    //header('location: RYANS LISTING FILE NAME.php');

    function handleListingData(){
        
        $showings=DBTransactorFactory::build("Listings");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $showings->update($_POST, ["MLS_number" => 1]);
            } catch(Exception $e) {
                echo $e->getMessage() . "<br\>";
            }
            
        }
    }
?>
