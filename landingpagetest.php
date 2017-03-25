<?php
	session_start();
    include "./DBTransactor/DBTransactorFactory.php";

    function Login(){
    	//Start session

		//Establish Database Connection
        $agents = DBTransactorFactory::build("Agents");

		//Check empty username
		if(empty($_POST['username'])){
			//echo("UserName is empty!<br/>");
			return false;
		}

		//Check empty pw
		if(empty($_POST['password'])){
			//echo("Password is empty!<br/>");
			return false;
		}

		//Extract variables from post
		$username = $_POST['username'];
		$password = $_POST['password'];

		//Check if user exists
		$userExists = false;
        
        $arr = Array("user_login" => $username);
        
        $result = $agents->select(['*'], $arr);

		if (!empty($result)) {
			if (count($result) == 1) {
                $hash = $agents->select(['password'], ['user_login' => $username]);
                //var_dump($hash);
                foreach($hash as $key => $val) {
                    if(password_verify($password, $val['password'])) {
                        $userExists = true;
                    } else {
                        $userExists = false;
                    }
                }
			} else {
				$userExists = false;
			}
		} else {
		   echo("User doesn't exist");
		}
        
        unset($password);
		//Start session
		if($userExists == true) {
			//session_start(); //PHP gives a warning if session_start() isn't declared at the top. Commented for now.

			$_SESSION['name'] = $username;
			echo "You have been logged in.<br/>Hello, " . $username ."!<br/>";


			$_SESSION['number'] = rand(1, 10);
			echo "Your number is " . $_SESSION['number'] . "!<br/>";

		} else {
			echo "User does not exist.  You have not been logged in.<br/>";
		}
	}
?>

<head>
</head>
<body>
	<?php Login(); ?>
	<a href="./sessiontest.php">Session test</a> <br/>
	<a href="./logouttest.php">Logout</a>
	<a href="./changepass.php">Change Password</a>
	<a href="./Listing/inputTest.php">Add A New Listing</a>
	<br>
	<a class='btn btn-default' href="./detailedlisting.php?MLS=2">View A detailed Listing</a> <a class='btn btn-default' href="./Listing/listings.php">View your listings</a>
</body>
