<!-- 
    File: changepasstest.php
    Change password code.  
    Given an agent's username, communicates with database to update agent's password. 

-->

<!-- PHP Functions -->
<?php
    function changePass() {
        $DB_LOCATION = 'localhost';  //Server URL
        $DB_USERNAME = 'root';       //Database access username
        $DB_PW       = '';           //Database access password
        $DB_NAME     = 'ParagonMLS'; //Name of database to be accessed
        $TABLE_NAME  = 'Agents';     //Name of the table to be accessed

        //Obtain Agent ID and Username. Hardcoded for now.
        //session_start();
        //$AGENT_USERNAME = $_SESSION['name'];
        
        $AGENT_USERNAME = 'jbonds';    //Username for this agent. Must obtain this from session.
        //$AGENT_ID = 1;               //Must obtain this from current session

        // Connect to DB
        $conn = new mysqli($DB_LOCATION, $DB_USERNAME, $DB_PW, $DB_NAME);
        
        //Check connection to database.
        if ($conn->connect_error) {
            echo "Connection failed: " . $conn->connect_error;
        } else {
            //echo "Connection successful<br/>";
        } 

        $query = "SELECT * FROM " . $TABLE_NAME . " ";
        $query .= "WHERE user_login = \"" . $AGENT_USERNAME . "\";";

        //Query database for username
        $result = $conn->query($query);

        // Check if user exists
        if ($result) {
            if ($result->num_rows == 1) {
                $userExists = true;
            } else {
                $userExists = false;
            }
        } else {
            echo $conn->error;
        }

        if ($userExists == true) {
            //User exists. Go ahead and change password
           	
            //Sanitize the input
            $newPass = sanitizer($_POST['newPass']);
            $confirmPass = sanitizer($_POST['updatedPass']);

            //Check if passwords match
            if (strcmp($newPass, $confirmPass) != 0) {
                echo "Could not change your password. Passwords do not match!";
                //$conn->close();
            } else {
                $query = "UPDATE " . $TABLE_NAME . " SET password=" . "'" . $confirmPass . "'" . " WHERE user_login=" . "'" . $AGENT_USERNAME . "'";
                
                //Talk to database and update this agents table entry
                if (mysqli_query($conn, $query)) {
                	echo "Password succesfully changed! <br/>";	
                	//$conn->close();
                } else {
            		echo "Could not change your password. SQL Error.<br/>";
            		echo $conn->error;
            		//$conn->close();
            		//exit();
            	}
            }
        } else {
            //That means user doesn't exist and this will be serious error
            //We must ensure that we get the username for agent correctly

            //$conn->close(); //Close connection to database if user doesn't exist
            echo "Could not change your password. Agent does not exist in database. Contact your system administrator.<br/>";
        }

        //Close database connection
        $conn->close();
    }

    function sanitizer($data) {
  		return htmlspecialchars(stripslashes(trim($data)));
    }
?>

<body>
	<?php changePass(); ?>
	<a href="./logintest.php">Login</a><br/>
	<a href="./changepass.php">Change Your Password</a><br/>
</body>