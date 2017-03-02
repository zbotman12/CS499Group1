<!-- DB Trasactor testing-->

<?php 
    include 'DBTransactorFactory.php';

    //Create DBTransactors. All constructors automatically called. 
    //Instantiated objects are all connected to the database where they can each edit their corresponding tables.
    
    try {
        //$agencies           = DBTransactorFactory::build("Agencies");
        $agents               = DBTransactorFactory::build("Agents");
        //$listings           = DBTransactorFactory::build("Listings");
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

    echo "Inserting into Agents table... <br/>";    
    echo "Calling insert() <br/>";
    try {
        $agents->insert($agent_no_id);
    }
    catch (Exception $e) {
        echo $e->getMessage() . "<br/>";
    }
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

    /* Test select */
    //$w1 = Array('password' => 'ryank');

    $o = $agents->selectAll();
    //$o = $agents->select(['agent_id', 'first_name', 'last_name'], []);

    $agents->printer($o);

    echo "Done! Test complete. <br/>";
?>
