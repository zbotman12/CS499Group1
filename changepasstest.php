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
         
        $username = 'jbonds';          //Username for this agent. Must obtain this from session.
        //$AGENT_ID = 1;               //Must obtain this from current session

        // Connect to DB
        $conn = new mysqli($DB_LOCATION, $DB_USERNAME, $DB_PW, $DB_NAME);
        
        //Check connection to database.
        if ($conn->connect_error) {
            //echo "Connection failed: " . $conn->connect_error;
        } else {
            //echo "Connection successful<br/>";
        } 

        //Quarantine Zone
        $password    = sanitizer($_POST['currentPass']);
        $newPass     = sanitizer($_POST['newPass']);
        $confirmPass = sanitizer($_POST['updatedPass']);

        //Build Query
        $query = "SELECT * FROM " . $TABLE_NAME . " ";
        $query .= "WHERE user_login = \"" . $username . "\" ";
        $query .= "AND password = \"" . $password . "\";";

        //Query database for username
        $result = $conn->query($query);
       
        //Check if user exists
        $userExists = false;

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
            //Check if new passwords match
            if (strcmp($newPass, $confirmPass) != 0) {
                echo "Could not change your password. Passwords entered do not match!<br/>";
            } else {
                $query = "UPDATE " . $TABLE_NAME . " SET password=" . "'" . $confirmPass . "'" . " WHERE user_login=" . "'" . $username . "'";
                
                //Talk to database and update this agents table entry
                if (mysqli_query($conn, $query)) {
                    echo "Password successfully changed! <br/>"; 
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
            echo "Could not change your password. Agent does not exist in database. Please input your password or contact your system administrator.<br/>";
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
