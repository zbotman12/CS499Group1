<?php 
	//Start session so as to be able to read variables
	//TODO: Set relative path root to website base
	if(session_id() == null)
		{
			session_start(); 
		}
?>
<head>
    <link href="/style/bootstrap.css" rel="stylesheet">
    <link href="/style/detailedListing.css" rel="stylesheet">
    <script src="/js/jquery-1.11.3.js"></script>
    <script src="/js/bootstrap.min.js"></script>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
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
		
		.btn-text {
			margin-left: 5px;
		}
		
		@media screen and (max-width: 768px) {
			.btn-text {
				display: none;
			}
		}
	}
		
	</style>
</head>

<!--Create header-->
<div class="site-header">
	<a href="/listings.php" class="btn">
		<span class="glyphicon glyphicon-home"></span><span class="btn-text">Home</span>
	</a>

	<?php if(!isset($_SESSION['number'])){ ?>
		<!--If session is not set-->
		<a href="/login.php" class="btn">
			<span class="glyphicon glyphicon-user"></span><span class="btn-text">Login</span>
		</a>

	<?php } else { ?>
		<!--If session is set-->
		<a href="/agentaccount.php" class="btn text-button">
			<span class="glyphicon glyphicon-user"></span><span class="btn-text">My Account</span>
		</a>
		<a href="/Listing/agentListingsDisplay.php" class="btn text-button">
			<span class="glyphicon glyphicon-briefcase"></span><span class="btn-text">My Listings</span>
		</a>
		<a href="/logout.php" class="btn right text-button">
			<span class="glyphicon glyphicon-log-out"></span><span class="btn-text">Logout</span>
        </a>
		<a href="/Showing Schedule/agentShowings.php" class="btn">
			My Showings
		</a>
	<?php } ?>
</div>
