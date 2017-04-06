<head>
	<title>Picture format error.</title>
</head>
<body>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php";
  		   include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
	?>
	<div class="container-fluid">
		<h2>Format error.</h2>
		<hr/>
		<?php echo "Sorry, we could not upload your pictures. One of your files has an unacceptable type. <br> We only accept jpg, jpeg, png, and gif images. Please upload appropriate type of image in your listings and try again. <br>"; ?>
	</div>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
