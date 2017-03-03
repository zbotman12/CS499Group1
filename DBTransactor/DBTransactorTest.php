<!-- DB Trasactor testing-->

<?php 
    include 'DBTransactorFactory.php';

    //Create DBTransactors. All constructors automatically called. 
    //Instantiated objects are all connected to the database where they can each edit their corresponding tables.
    
    try {
        //$agencies           = DBTransactorFactory::build("Agencies");
        //$agents             = DBTransactorFactory::build("Agents");
        $listings           = DBTransactorFactory::build("Listings");
        //$showings           = DBTransactorFactory::Build("Showings");
        //$showings_feedback  = DBTransactorFactory::build("Showing_Feedback");
   
    } catch (Exception $e) {
      echo $e->getMessage() . "<br/>";
    }

    echo "DBTransactors created succesfully <br/>";

    //Test insertion by creating associative arrays of data.
    $agent_id = array('agency_id'           => '1',
                      'user_login'          => 'dasani',
                      'password'            => 'dasani',
                      'confirm_pass'        => 'dasani',
                      'first_name'          => 'Dasani',
                      'last_name'           => 'Water Bottle',
                      'email'               => 'dasani@email.com',
                      'agent_phone_number'  => '999-999-9999',
                      'company_name'        => 'British Intelligence Agency',
                      'agency_phone_number' => '999-999-9999',
                      'city'                => 'London',
                      'address'             => 'UK',
                      'zip'                 => '55555',
                      'address'             => '221B Baker Street');

    $agent_no_id = array('user_login'         => 'dasani1',
                         'password'           => 'dasani',
                         'confirm_pass'       => 'dasani',
                         'first_name'         => 'Dasani',
                         'last_name'          => 'Water Bottle',
                         'email'              => 'dasani@email.com',
                         'agent_phone_number' => '999-999-9999',
                         'company_name'       => 'British Intelligence Agency',
                         'agency_phone_number'=> '999-999-9999',
                         'city'               => 'London',
                         'address'            => 'UK',
                         'zip'                => '55555',
                         'address'            => '221B Baker Street');

    //Listing
    $listinga = array('Agents_listing_agent_id' => '2',
                      'price'                   => '200000',
                      'city'                    => 'Huntsville',
                      'state'                   => 'AL',
                      'zip'                     => '33333',
                      'address'                 => '221B Baker Street',
                      'square_footage'          => '200',
                      'number_of_bedrooms'      => '1',
                      'number_of_bathrooms'     => '1',
                      'room_desc'               => 'One room with window that looks out to street',
                      'listing_desc'            => 'close to cinema',
                      'additional_info'         => null,
                      'agent_only_info'         => '33321');

/*
    echo "Inserting into Agents table... <br/>";    
    echo "Calling insert() <br/>";
    try {
        $agents->insert($agent_no_id);
    }
    catch (Exception $e) {
        echo $e->getMessage() . "<br/>";
    }
*/    
    //echo "Calling insertAgent() <br/>";
    //$agents->insertAgent($agent_id);
    
    /*
    $set = array('password' => 'haha',
                 'email'    => 'changed@working.com'); 
    $where = array('user_login' => 'jbonds',
                   'password'   => 'hello');

    echo "Updating agent info...<br/>";
    $agents->update($set,$where); 
    */
/*
    $cond = array('user_login'    => 'dasani',
                  'password'      => 'dasani');

    $cond2 = array('user_login'   => 'dasani1',
                   'password'     => 'dasani');

    $agents->delete($cond);
    $agents->delete($cond2);
*/
/*
    echo "Inserting into listings table... <br/>";
    echo "Calling DBListing insert()...<br/>";

    try {
        $listings->insert($listinga);
    } catch (Exception $e) {
        echo $e->getMessage() . "<br/>";
    }
    
    echo "Inserted succesfully <br/>";
    $a = $listings->selectAll();
    $listings->printer($a);

    echo "<br/>";
*/
    //select the MLS number for $listinga
    $result = $listings->select(['MLS_number'], ['address' => '221B Baker Street']);

    //If multiple queries, alert user of which listing they would like to change.
    //For now, crash because we don't want multiple queries.
    if (count($result) > 1) {
        echo "Multiple queries!!!! <br/>";
        exit();
    }

    $mls = null;

    foreach ($result as $key => $val) {
        $mls = $val;
    }

    var_dump($result);
    echo "<br/>";
    echo "<br/>";
    $listings->printer($listings->selectAll());

    echo "Now modifiying entry for listing <br/> <br/>";
    
    $set = array('price' => '300000', 'zip' => '35818');
    $where = array ('MLS_number' => $mls['MLS_number']);

    $listings->update($set, $where);

    $listings->printer($listings->selectAll());

    
    echo "Removing listing <br/>";
    $listings->delete(['address' => '221B Baker Street', 'zip' => '35818']);

    
    $listings->printer($listings->selectAll());
    echo "<br/>";
    
    /* Test select */
    //$w1 = Array('password' => 'ryank');
    //$o = $agents->select(['agent_id', 'first_name', 'last_name'], []);
    
    // Print all entries in table
    //$agencies->printer($agencies->selectAll());
    //$agents->printer($agents->selectAll());
    echo "Done! Test complete. <br/>";
?>
