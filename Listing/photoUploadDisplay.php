<?php 
  //Check and make sure we have an active session. If not we need one so send the user to the login page.
   include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessioncheck.php";
 ?>
<!DOCTYPE html>
<html>
<head>
	<link
	href=formattingFile.css
	type="text/css"
			rel="stylesheet">		
	<title>Listing Photos</title>
</head>
<body>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
	<!-- action_page.php is a php file that handles the submitted input -->
	<div class="container-fluid">
		<form action="/Helpers/Listing/photoHandle.php" method="post" enctype="multipart/form-data" >
			<fieldset>
			<h2>Listing Photos</h2>
			<hr/>
			 Select image to upload:
			<input type="file" name="file1">
			<br>
			<input type="file" name="file2" > 	<br>
			<input type="file" name="file3"> 	<br>
			<input type="file" name="file4"> 	<br>
			<input type="file" name="file5"> 	<br>
			<input type="file" name="file6">
			<br>
			<input type="submit" value="Continue">
			<input type="reset">
			</fieldset>
		</form>
	</div>
	<br/>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
</html>