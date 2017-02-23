<!-- DB Trasactor testing-->

<?php 
    include 'DBTransactorFactory.php';

	//Create DBTransactors. All constructors automatically called. 
    //Instantiated objects are all connected to the database where they can each edit their corresponding tables.
	$agencies  			= DBTransactorFactory::build("Agencies");
	$agents    			= DBTransactorFactory::build("Agents");
    $listings  			= DBTransactorFactory::build("Listings");
    $showings  			= DBTransactorFactory::Build("Showings");
    $showings_feedback  = DBTransactorFactory::build("Showing_Feedback");

    echo "DBTransactors created succesfully <br/>";

    //Test insertion by creating associative arrays of data.
    $agent = array();
?>
