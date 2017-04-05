<head>
	<title>House already listed</title>
</head>
<body>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php";
  		   include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
	?>
	<div class="container-fluid">
		<h2>House already listed</h2>
		<hr/>
		<?php echo "Sorry, could not add your listing to the database. Address is already in database.<br>"; ?>
	</div>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
