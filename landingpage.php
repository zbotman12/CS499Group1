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
		   //echo("User doesn't exist");
		}
        
        unset($password);
		//Start session
		if($userExists == true) {
			//session_start(); //PHP gives a warning if session_start() isn't declared at the top. Commented for now.

			$_SESSION['name'] = $username;
			//echo "You have been logged in.<br/>Hello, " . $username ."!<br/>";

			$getId= $agents->select(['agent_id'],['user_login' => $username]);
			$id=array_pop($getId);
			
			$_SESSION['number'] = $id['agent_id'];
			//echo "Your number is " . $_SESSION['number'] . "!<br/>";

		} else {
			//echo "User does not exist.  You have not been logged in.<br/>";
		}
	}
?>

<head>
	<title>Login Result</title>
</head>
<body>
	<?php Login(); ?>
	<?php include "header.php"; ?>
	<div class="container-fluid">
		<h2>Login</h2>
		<hr/>
		
		<?php if(isset($_SESSION['name'])) { 
			echo "You have been logged in.<br/>Hello, " . $_SESSION['name'] ."!<br/>";
			//echo "Your number is " . $_SESSION['number'] . "!";
		} else { 
			echo "User does not exist.  You have not been logged in.";
		} ?>
		<br/>
		
		<?php if(isset($_SESSION['name'])) { ?> 
			<!--Display these options only if user is logged in-->
			<a href="./Listing/inputTest.php" class="btn btn-default">
				Add A New Listing
			</a>
			<a href="./Listing/listings.php" class='btn btn-default'>
				View your listings
			</a>
		<?php } else { ?>
			<!--Display these options only if user is not logged in-->
			<a href="http://207.98.161.214/login.php" class="btn btn-default">
				Retry
			</a>
		<?php } ?>
		
		<a href="./sessiontest.php" class="btn btn-default">
			Session Test
		</a>
		<a href="./changepass.php" class="btn btn-default">
			Change Password
		</a>
	</div>
	<br/>
	<?php include "footer.php"; ?>
</body>
