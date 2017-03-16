<?php
	// Always include this file at the beginning of any code to avoid PHP warnings
	function getNumber() {
		session_start();
		if(isset($_SESSION['number'])){
			//echo "Your number is " . $_SESSION['number']) . "!";
			echo "Your number is " . $_SESSION['number'] ."!<br/>";
		} else {
			echo "Your number is not set!<br/>";
		}
	}
?>

<head>
</head>
<body>
	<?php getNumber(); ?>
	<a href="./logintest.php">Login</a><br/>
	<a href="./logouttest.php">Logout</a>
</body>
