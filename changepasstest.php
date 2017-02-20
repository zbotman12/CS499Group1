<!-- 
    File: changepasstest.php
    Change password code.
    Given an agent's username, communicates with database to update agent's password. 
-->

<!-- PHP Functions -->
<?php
    function changePassword(){
        //Establish Database Connection 
        include "dbconnect.php";
        //Resume session. If no session found, rout to login page
        include "sessioncheck.php";

        //Obtain Agent ID and Username.
        if(isset($_SESSION['name'])) {
            $username = $_SESSION['name'];  //Username for this agent. Must obtain this from session.
            //$AGENT_ID = 1;                //Must obtain this from current session
        } else {
            $username = $_POST['username'];
        }

        //Quarantine Zone
        $password    = sanitizer($_POST['currentPass']);
        $newPass     = sanitizer($_POST['newPass']);
        $confirmPass = sanitizer($_POST['updatedPass']);

        //Build Query
        $query = "SELECT * FROM " . $TABLE_NAME . " ";
        $query .= "WHERE user_login = \"" . $username . "\" ";
        $query .= "AND password = \"" . $password . "\";";

        //Query database for username. This also checks if passwords match. If
        //not, query fails. User doesn't "exist" in the sense that it's not that
        //agent that's login in.
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
        
        mysqli_free_result($result);

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

<head>
</head>
<body>
    <?php changePassword(); ?>
    <a href="./sessiontest.php">Session test</a> <br/>
    <a href="./logouttest.php">Logout</a>
</body>
