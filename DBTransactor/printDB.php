<?php
    include 'DBTransactorFactory.php';
    try {
        $agencies = DBTransactorFactory::build("Agencies");
        $agents   = DBTransactorFactory::build("Agents");
        $listings = DBTransactorFactory::build("Listings");
        $showings = DBTransactorFactory::build("Showings");
        $showings_FB = DBTransactorFactory::build("Showing_Feedback");
    } catch (Exception $e) {
          echo $e->getMessage() . "<br/>";
    }
    
    echo "Printing Agencies <br/>";
    $agencies->printer($agencies->selectAll());

    echo "Printing Agents <br/>";
    $agents->printer($agents->selectAll());
    
    echo "Printing Listings <br/>";
    $listings->printer($listings->selectAll());
    
    echo "Printing Showings <br/>";
    $showings->printer($showings->selectAll());
    
    echo "Printing Showings Feedback <br/>";
    $showings_FB->printer($showings_FB->selectAll());

?>
