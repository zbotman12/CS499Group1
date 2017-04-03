<?php 
	function Logout() {
		session_start();
		unset($_SESSION);
		session_destroy();
	}
?>

<head>
	<title>Logout</title>
	<style>
		a {
			display: inline;
		}
	</style>
</head>
<body>
	<?php Logout(); ?>
	<?php include "header.php";?>
	<div class="container-fluid">
		<h2>Logout</h2>
		<hr/>
		<p style="margin-bottom: 0;">You have been logged out!</p>
		<br/>
		<!-- We don't really need session test anymore. Uncommented in case we need to test. - Michael
		<a href="./sessiontest.php" class="btn btn-default">
			Session Test
		</a>
		--> 
		<!-- Change password looks weird after signing out. Uncommented for now. - Michael
		<a href="./changepass.php" class="btn btn-default">
			Change Password
		</a>
		-->
	</div>
	<br/>
	<?php include "footer.php";?>
</body>