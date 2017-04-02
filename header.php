<?php 
	//Start session so as to be able to read variables
	//TODO: Set relative path root to website base
	if(session_id() == null)
		{
			session_start();
		}
?>
<head>
	<link href="/style/bootstrap.min.css" rel="stylesheet">
    <link href="/style/bootstrap.css" rel="stylesheet">
    <link href="/style/detailedListing.css" rel="stylesheet">
    <script src="/js/jquery-1.11.3.js"></script>
    <script src="/js/bootstrap.min.js"></script>
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
</head>

<!--Create header-->
<div class="site-header">
	<a href="http://
		<?php echo $_SERVER['SERVER_NAME'] . "/listings.php"; ?>
	" class="btn">
		Home
	</a>

	<?php if(!isset($_SESSION['number'])){ ?>
		<!--If session is not set-->
		<a href="http://
		<?php echo $_SERVER['SERVER_NAME'] . "/login.php"; ?>
		" class="btn">
			Login
		</a>

	<?php } else { ?>
		<!--If session is set-->
		<a href="http://
		<?php echo $_SERVER['SERVER_NAME'] . "/Listing/agentListingsDisplay.php"; ?>
		" class="btn">
			My Listings
		</a>
		<a href="http://
		<?php echo $_SERVER['SERVER_NAME'] . "/logout.php"; ?>
		" class="btn right">
			Logout
		</a>
	<?php } ?>
</div>