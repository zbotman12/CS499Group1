<?php
    /* 
        File: changepasstest.php
        Change password code.
        Given an agent's username, communicates with database to update agent's
        password.
    */
    //Resume session. If no session found, rout to login page
    include "sessioncheck.php";

    function changePassword(){

        //Establish Database Connection 
        include './DBTransactor/DBTransactorFactory.php';
        $agents = DBTransactorFactory::build("Agents");
        
        $_POST = array_map("sanitizer", $_POST);
        
        //Obtain Agent ID and Username.
        if(isset($_SESSION['name'])) {
            $username = $_SESSION['name'];  //Username for this agent. Must obtain this from session.
            //$AGENT_ID = 1;                //Must obtain this from current session
        } else {
            $username = $_POST['username'];
        }

        $password    = $_POST['currentPass'];
        $newPass     = $_POST['newPass'];
        $confirmPass = $_POST['updatedPass'];

        $result = $agents->select(['*'], ["user_login" => $username]);

        $userExists = false;

        if (!empty($result)) {
            if (count($result == 1)) {
                //Verify password against database.
                $hash = $agents->select(['password'], ['user_login' => $username]);

                foreach($hash as $key => $val) {
                    if(password_verify($password, $val['password'])) {
                        $userExists = true;
                    }
                    else {
                        $userExists = false;
                    }
                }
            } else {
                $userExists = false;
            }
        } 


        if ($userExists == true) {
            //Check if new passwords match
            if (strcmp($newPass, $confirmPass) != 0) {
                echo "Could not change your password. Passwords entered do not match!<br/>";
            } else {

                //Update password
                $ops = ['cost' => 10];
                $hash = password_hash($newPass, PASSWORD_DEFAULT, $ops);

                if ($agents->update(['password' => $hash], ['user_login' => $username])) {
                    echo "Password successfully changed! <br/>"; 
                    //$conn->close();
                } else {
                    echo "Could not change your password. SQL Error.<br/>";
                }
            }
        } else {
            //That means user doesn't exist and this will be serious error
            //We must ensure that we get the username for agent correctly
            echo "Could not change your password. Agent does not exist in database. Please input your password or contact your system administrator.<br/>";
        }

        unset($password);
        unset($newPass);
        unset($confirmPass);
    }

    function sanitizer($data) {
          return htmlspecialchars(stripslashes(trim($data)));
    }
?>

<head>
	<title>Change Your Password</title>
</head>
<body>
	<?php include "header.php"; ?>
	<div class="container-fluid">
		<h2>Change Your Password</h2>
		<hr/>
		<?php changePassword(); ?>
		<a href="./sessiontest.php" class="btn btn-default">Session test</a>
		<a href="./logout.php" class="btn btn-default">Logout</a>
	</div>
	<?php include "footer.php"; ?>
</body>
