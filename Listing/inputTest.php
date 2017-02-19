<!DOCTYPE html>
<html>
<head>
<link
	href=formattingFile.css
	type="text/css"
	rel="stylesheet">
	
<!-- <meta charset="UTF-8"> -->
<title>"Your listings"</title>
</head>
<body>
<!-- action_page.php is a php file that handles the submitted input --> 
<form action="inputHandle.php" method="post" enctype="multipart/form-data">
	<fieldset>
	<legend>Listing Information</legend>

    <br><br><label class= "field" for="price">List Price:</label><br>
  	<input type="text" name="price" value=""><br><br>
  	<label class= "field" for="desc">Description:</label><br>
  	<textarea name="desc" rows="10" cols="30">
  	</textarea><br><br>
   	<label class= "field" for="address">Address:</label><br>
  	<input type="text" name="address" value=""><br><br>
    <label class= "field" for="city">City:</label><br>
  	<input type="text" name="city" value=""><br><br>
    <label class= "field" for="state">State:</label><br>
  	<input type="text" name="state" value=""><br><br>
    <label class= "field" for="zip">Zip:</label><br>
  	<input type="text" name="zip" value=""><br><br>
    <label class= "field" for="footage">Square Footage:</label><br>
  	<input type="text" name="footage" value=""><br><br>
    <label class= "field" for="roomDesc">Room Descriptions:</label><br>
    <textarea name="roomDesc" rows="10" cols="30">
	</textarea><br>
	<label class= "field" for="num_bedrooms">Number of Rooms:</label><br>
  	<input type="text" name="num_bedrooms" value=""><br><br>
    <label class= "field" for="num_bathrooms">Number of Bathrooms:</label><br>
  	<input type="text" name="num_bathrooms" value=""><br><br>
  	<label class= "field" for="localDesc">Location Description:</label><br>
    <textarea name="locaDesc" rows="10" cols="30">
	</textarea><br><br>
   	<label class= "field" for="alarm">Alarm Information:</label><br>
  	<input type="text" name="alarm" value=""><br><br>
  	
  	<input type="submit" value="Continue">
   	<input type="reset">
   	</fieldset>
</form>
</body>
</html>