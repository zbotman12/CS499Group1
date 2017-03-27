<?php 
	function Logout() {
		session_start();
		unset($_SESSION);
		session_destroy();
	}
?>

<head></head>
<body>
	<?php include "header.php";?>
	<?php Logout(); ?>
	You have been logged out!<br/>
	<a href="./logintest.php">Login</a><br/>
	<a href="./sessiontest.php">Session test</a> <br/>
	<a href="./changepass.php">Change Password</a> <br/>
	<?php include "footer.php";?>
</body>