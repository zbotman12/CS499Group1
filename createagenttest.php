<!-- 
    File: createagenttest.php
    Makes an agent and agency entry in database.    
-->

<!-- PHP code -->
<?php
    function createAgent(){
        $DB_LOCATION     = 'localhost';  //Server URL
        $DB_USERNAME     = 'root';       //Database access username
        $DB_PW           = '';           //Database access password
        $DB_NAME         = 'ParagonMLS'; //Name of database to be accessed
        $AGENTS_TABLE    = 'Agents';     
        $AGENCIES_TABLE  = 'Agencies';  

        //Get Company data
        $company = array(
                   "Company Name"         => $_POST['company_name'], 
                   "Company Address"      => $_POST['company_address'], 
                   "Company City"         => $_POST['company_city'], 
                   "Company State"        => $_POST['company_state'], 
                   "Company Zip"          => $_POST['company_zip'], 
                   "Company Phone Number" => $_POST['company_phone_number']);

        //Get Agent Credentials
        $agent_creds = array(
                       "Username"         => $_POST['username'],
                       "Password"         => $_POST['password'],
                       "Confirm Password" => $_POST['confirmPass']);
        
        //Get Agent Information
        $agent_info = array(
                      "First Name"         => $_POST['firstname'],
                      "Last Name"          => $_POST['lastname'],
                      "Email"              => $_POST['email'],
                      "Agent Phone Number" => $_POST['agent_phone_number']);
        
        //Quarantine zone
        $company     = array_map("sanitizer", $company);
        $agent_creds = array_map("sanitizer", $agent_creds);
        $agent_info  = array_map("sanitizer", $agent_info);
        
        //Check for empty fields
        //PHP uses short circuit so this will check each of these arrays sequentially
        if(hasEmptyFields($company) or hasEmptyFields($agent_creds) or hasEmptyFields($agent_info)) {
            return false;
        }

        //Check if passwords match
        if (strcmp($agent_creds['Password'], $agent_creds['Confirm Password']) != 0) {
            echo "Could not create agent. Passwords do not match! <br/>";
            return false;
        }

        //Connect to database
        $conn = new mysqli($DB_LOCATION, $DB_USERNAME, $DB_PW, $DB_NAME);

        //Check for connection errors
        if ($conn->connect_error) {
            echo "Connection failed: " . $conn->connect_error;
        } else {
            echo "Connection successful<br/>"; 
        }

        //Build query to check existence of Agency  
        $query  = "SELECT * FROM " . $AGENCIES_TABLE . " ";
        $query .= "WHERE company_name = \"" . $company['Company Name'] . "\" ";
        
        //Query the database
        $agency_results = $conn->query($query);
        $agency_exists = false;

        //Check if agency exists
        if ($agency_results) {
            if ($agency_results->num_rows == 1) {
                echo "Agency exists <br/>";
                $agency_exists = true;  
            } else {
                echo "Agency doesn't exist<br/>";
                $agency_exists = false;
            }
        } else {
            echo $conn->error;
        }

        if ($agency_exists) { //Agency exists. Get its agency ID. Create agent and assign agency ID obtained. 
            
            //Build query to select agency id
            $query  = "SELECT agency_id FROM " . $AGENCIES_TABLE . " WHERE company_name=" . "'" . $company['Company Name'] . "'" .";";

            //Fetch row of agency_id
            $r = $conn->query($query);
            $row = $r->fetch_assoc();
            
            //echo $row['agency_id'] . "<br/>";
            
            //Build insert agent query
            $agent_query = "INSERT INTO " . $AGENTS_TABLE . " VALUES (NULL,";
            $agent_query .= "'" . $row['agency_id']                 . "'" . ",";
            $agent_query .= "'" . $agent_creds['Username']          . "'" . ",";
            $agent_query .= "'" . $agent_creds['Password']          . "'" . ",";
            $agent_query .= "'" . $agent_info['First Name']         . "'" . ",";
            $agent_query .= "'" . $agent_info['Last Name']          . "'" . ",";
            $agent_query .= "'" . $agent_info['Email']              . "'" . ",";
            $agent_query .= "'" . $agent_info['Agent Phone Number'] . "'" . ");";
            
            //echo $agent_query . "<br/>";
            
            //IMPORTANT
            //Check if agent already exists in database!
            $dup_query = "SELECT * FROM " . $AGENTS_TABLE . " WHERE user_login=" . "'" . $agent_creds['Username'] . "';";    
            $dup_results = $conn->query($dup_query);

            if ($dup_results) {
              if ($dup_results->num_rows == 1) {
                  echo "Username already exists!<br/> Cannot create agent. <br/>";
                  $conn->close();
                  return false;
              } 
            } else {
                echo $conn->error;
            }

            //Query the database. Insert Agent into Agents table
            $results = $conn->query($agent_query);
            
            //Check results. $results is either true or false
            if($results) {
                    echo "Created agent successfully!<br/>";
            } else {
                echo "Could not create agent! Database error!<br/>";
                echo $conn->error;
            }
        } else { //Agency doesn't exist. Create a new agency. After creating agency. Give agency ID to agent. 
            
            //Build agency query 
            $agency_q = "INSERT INTO " . $AGENCIES_TABLE   . " VALUES (NULL,";
            $agency_q .= "'" . $company['Company Name']         . "'" . ",";
            $agency_q .= "'" . $company['Company Phone Number'] . "'" . ",";
            $agency_q .= "'" . $company['Company City']         . "'" . ",";
            $agency_q .= "'" . $company['Company State']        . "'" . ",";
            $agency_q .= "'" . $company['Company Zip']          . "'" . ",";
            $agency_q .= "'" . $company['Company Address']      . "'" . ");";
            
            //echo $agency_q . "<br/>";
            
            //Insert agency into database
            $result = $conn->query($agency_q);

            //Check results of insertion
            if ($result) { 
                echo "Created Agency Successfully! <br/>";
                echo "Creating agent... <br/>";
                
                //Check if agent username is in database. Ensures unique usernames.
                $dup_query = "SELECT * FROM " . $AGENTS_TABLE . " WHERE user_login=" . "'" . $agent_creds['Username'] . "';";            
                $dup_results = $conn->query($dup_query);

                if ($dup_results) {
                  if ($dup_results->num_rows == 1) {
                      echo "Username already exists!<br/> Cannot create agent. <br/>";
                      $conn->close();
                      return false;
                  } 
                } else {
                    echo $conn->error;
                }

                //Build agent entry as username is unique
                $query = "SELECT agency_id FROM " . $AGENCIES_TABLE . " WHERE company_name=" . "'" . $company['Company Name'] . "'" .";";
                $r = $conn->query($query);
                $row = $r->fetch_assoc();

                //echo $row['agency_id'] . "<br/>";

                //Build insert agent query
                $agent_query = "INSERT INTO " . $AGENTS_TABLE. " VALUES (NULL,";
                $agent_query .= "'" . $row['agency_id']                 . "'" . ",";
                $agent_query .= "'" . $agent_creds['Username']          . "'" . ",";
                $agent_query .= "'" . $agent_creds['Password']          . "'" . ",";
                $agent_query .= "'" . $agent_info['First Name']         . "'" . ",";
                $agent_query .= "'" . $agent_info['Last Name']          . "'" . ",";
                $agent_query .= "'" . $agent_info['Email']              . "'" . ",";
                $agent_query .= "'" . $agent_info['Agent Phone Number'] . "'" . ");";
                //echo $agent_query . "<br/>";

                //Insert agent into database
                $results = $conn->query($agent_query);
                
                //Check if agent was added succesfully
                if($results) {
                    echo "Created agent successfully!<br/>";
                } else {
                    echo "Could not create agent! Database error!</br>"; 
                }
            } else {
                echo "Could not create Agency! Could not create agent credentials! Database error! <br/>";
            }
        }

        $conn->close();
    }

    function sanitizer($data) {
        return htmlspecialchars(stripslashes(trim($data))); 
    }

    //Given an associative array with strings as values, determines if 
    //any of the values are empty
    function hasEmptyFields($arr) {
        foreach($arr as $k => $v) 
        {
            if (empty($v)){
              echo "$k cannot be empty </br>";
              return true;
            }
        }
        return false;
    }
?>

<body>
    <?php createAgent(); ?>
    <a href="./logintest.php">Login</a><br/>
</body>

