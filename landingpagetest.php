<?php
	function Login(){

		//Set database variables
		$DB_LOCATION = 'localhost';  //Server URL
		$DB_USERNAME = 'root';       //Database access username
		$DB_PW       = '';  		 //Database access password
		$DB_NAME     = 'ParagonMLS'; //Name of database to be accessed
		$TABLE_NAME	 = 'Agents';	 //Name of the table to be accessed
		
		//$DB_USERNAME = 'nick';       //Database access username
		//$DB_PW       = 'diliberti';  //Database access password
		//$DB_NAME     = 'ParagonMLS';    //Name of database to be accessed
		
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

		//Connect to DB
		$conn = new mysqli($DB_LOCATION, $DB_USERNAME, $DB_PW, $DB_NAME);

		if ($conn->connect_error) {
			//echo "Connection failed: " . $conn->connect_error;
		} else {
			//echo "Connection successful<br/>";
		}

		//Check existence in DB
		$query = "SELECT * FROM " . $TABLE_NAME . " ";
		$query .= "WHERE user_login = \"" . $username . "\" ";
		$query .= "AND password = \"" . $password . "\";";

		//echo "Query: " . $query . "<br/>";

		$result = $conn->query($query);

		if ($result) {
			if ($result->num_rows == 1) {
				$userExists = true;
			} else {
				$userExists = false;
			}
		} else {
			echo $conn->error;
		}

		//Close db connection
		$conn->close();

		//Start session
		if($userExists == true) {
			session_start();

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
</body>
