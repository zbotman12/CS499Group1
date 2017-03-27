<?php 
	//Start session so as to be able to read variables
	//TODO: Set relative path root to website base
	session_start();
?>

<!--Declare formatting-->
<style>
	.site-header {
		background-color: rgb(96, 157, 255);
		padding: 5px;
	}
	.site-header > a {
		background-color: rgb(255, 204, 0);
	}
	.site-header > .right {
		float: right;
	}
</style>

<!--Create header-->
<div class="site-header">
	<a href="http://207.98.161.214/listings.php" class="btn">
		Home
	</a>

	<?php if(!isset($_SESSION['number'])){ ?>
		<!--If session is not set-->
		<a href="http://207.98.161.214/login.php" class="btn">
			Login
		</a>

	<?php } else { ?>
		<!--If session is set-->
		<a href="http://207.98.161.214/Listing/listings.php" class="btn">
			My Listings
		</a>
		<a href="http://207.98.161.214/logout.php" class="btn right">
			Logout
		</a>
	<?php } ?>
</div>