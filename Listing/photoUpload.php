<?php 
  //Check and make sure we have an active session. If not we need one so send the user to the login page.
  include './../sessioncheck.php';
 ?>
<!DOCTYPE html>
<html>
<head>
<link
href=formattingFile.css
type="text/css"
		rel="stylesheet">		
<title>"Listing Photos"</title>
</head>
<body>
	<!-- action_page.php is a php file that handles the submitted input -->
	<form action="photoHandle.php" method="post" enctype="multipart/form-data" >
		<fieldset>
		<legend>Listing Photos</legend>
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
</body>
</html>