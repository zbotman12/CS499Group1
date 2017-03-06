<!-- DB Trasactor testing-->

<?php 
    include 'DBTransactorFactory.php';

    //Create DBTransactors. All constructors automatically called. 
    //Instantiated objects are all connected to the database where they can each edit their corresponding tables.
    
    try {
        //$agencies           = DBTransactorFactory::build("Agencies");
        //$agents             = DBTransactorFactory::build("Agents");
        //$listings           = DBTransactorFactory::build("Listings");
        //$showings           = DBTransactorFactory::build("Showings");
        $showings_fb        = DBTransactorFactory::build("Showing_Feedback");
   
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
    $listinga = array('Agents_listing_agent_id' => '1',
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
    
    // Time Zone Codes (PT, MT, CT, ET)
    // Time format for mktime(hours, minutes, seconds, month, day, year);
    $showinf = array('Listings_MLS_number'     => '1',
                     'Agents_showing_agent_id' => '1',
                     'start_time'              => date("Y-m-d H:i:s", mktime(10, 30, 0, 10, 27, 1994)),
                     'end_time'                => date("Y-m-d H:i:s", mktime(11,30, 0, 10, 27, 1994)),
                     'time_zone'               => 'CT',
                     'is_house_vacant'         => 1,
                     'customer_first_name'     => 'Jason',
                     'customer_last_name'      => 'Bourne',
                     'lockbox_code'            => null);

    $s = array('idShowing_Feedback'              => '2',
               'Showings_showing_id'             => '2',
               'customer_interest_level'         => '5',
               'showing_agent_experience_level'  => '10',
               'customer_price_opinion'          => "This house is marvelous!",
               'additional_notes'                => "Customer says house is too expensive but says it's a nice house."); 
/*

    echo "Testing showing_fb->insert() <br/>";
    try {
      $showings_fb->insert($showingfb);
    } catch (Exception $e) {
      echo $e->getMessage() . "<br/>";
    }

    echo "Insert complete! <br/>";

*/

    $showings_fb->printer($showings_fb->selectAll());

    echo "<br/> Testing update showing_fb <br/>";
    $showings_fb->update(["customer_price_opinion" => "This house is b-okay!"] , ["Showings_showing_id" => 2]);

    $showings_fb->printer($showings_fb->selectAll());

    echo "<br/> Testing Select()<br/>";
    $result = $showings_fb->select(['*'], ['Showings_showing_id' => 2]);
    echo "<br/>";
    var_dump($result);

/*
    echo "<br/> Testing delete()<br/>";
    $showings_fb->printer($showings_fb->selectAll());
    $showings_fb->delete(['idShowing_Feedback' => 3]);

    $showings_fb->printer($showings_fb->selectAll());
*/

/*
    $show_fb = array('idShowing_Feedback' => 1,
                     'Showings_showing_id' => '1');
*/

/*
    echo "Inserting into Agents table... <br/>";    
    echo "Calling insert() <br/>";
    try {
        $agents->insert($agent_no_id);
    }
    catch (Exception $e) {
        echo $e->getMessage() . "<br/>";
    }
    echo "Done creating agent Dasani <br/>";
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
/*
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

*/

/*
    echo "Now modifiying entry for listing <br/> <br/>";
    
    $set = array('price' => '300000', 'zip' => '35818');
    $where = array ('MLS_number' => $mls['MLS_number']);

    $listings->update($set, $where);

    $listings->printer($listings->selectAll());

    
    echo "Removing listing <br/>";
    $listings->delete(['address' => '221B Baker Street', 'zip' => '35818']);

    
    $listings->printer($listings->selectAll());
    echo "<br/>";
*/ 
/*
    echo "Calling Showings insert() <br/>";
    try {
      $showings->insert($showinf);
    } catch (Exception $e) {
      echo $e->getMessage() . "<br/>";
    }
    $showings->printer($showings->selectAll());
*/
/*
    $showings->printer($showings->selectAll());

    echo "Testing delete() <br/>";

    $showings->delete(['showing_id' => 2]);

    $showings->printer($showings->selectAll());
*/

/*
    echo "Testing select() <br/>";

    $result = $showings->select(['*'], ['showing_id' => 1]);
    echo "<br/>";
    var_dump($result);
    echo "<br/>";
    
*/
/*
    echo "Testing showing_fb->insert() <br/>";
    try {
      $showings_fb->insert($s);
    } catch (Exception $e) {
      echo $e->getMessage() . "<br/>";
    }

    echo "Insert complete! <br/>";

    $showings_fb->printer($showings_fb->selectAll());
*/
/*
    $showings->printer($showings->selectAll());
    echo "<br/>";
    echo "Modifying Showing information <br/>";
    echo "Testing update <br/>";
    $set = array('start_time' => date("Y-m-d H:i:s", mktime(2, 0, 0, 3, 10, 2017)),
                 'end_time'   => date("Y-m-d H:i:s", mktime(3, 30, 0, 3, 10, 2017)),
                 'customer_first_name' => "Alan",
                 "customer_last_name"  => "Turing");

    $showings->update($set, ['showing_id' => 1]);

    $showings->printer($showings->selectAll());
*/

    /* Test select */
    //$w1 = Array('password' => 'ryank');
    //$o = $agents->select(['agent_id', 'first_name', 'last_name'], []);
    
    // Print all entries in table
    //$agencies->printer($agencies->selectAll());
    //$agents->printer($agents->selectAll());
    echo "Done! Test complete. <br/>";
?>
