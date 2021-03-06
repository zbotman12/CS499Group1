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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$(".thousandChars").keyup(function(){
			  $(this).next().text("Characters remaining: " + (1000 - $(this).val().length));
			});
			$(".threeHundredChars").keyup(function(){
			  $(this).next().text("Characters remaining: " + (300 - $(this).val().length));
			});
		});
	</script>

	<!-- <meta charset="UTF-8"> -->
	<title>
		Your listings
	</title>
</head>

<body>
	<?php include "../header.php";  ?>
	<!-- action_page.php is a php file that handles the submitted input --> 
	<div class="container-fluid">
		<form action="inputHandle.php" method="post" enctype="multipart/form-data">
			<fieldset>
				<h2>Listing Information</h2>
				<hr/>
				<label class= "field" for="price">List Price:</label><br>
				<input type="text" name="price" value=""><br><br>
				<label class= "field" for="desc">Description:</label><br>
				<textarea name="desc" rows="10" cols="30" class="thousandChars"></textarea>
				<p class="remainingChars">Characters remaining: 1000</p>
				<br>
				<label class= "field" for="address">Address:</label><br>
				<input type="text" name="address" value=""><br><br>
				<label class= "field" for="city">City:</label><br>
				<input type="text" name="city" value=""><br><br>
				<label class= "field" for="state">State (Postal Code):</label><br>
				<input type="text" name="state" value=""><br><br>
				<label class= "field" for="zip">Zip:</label><br>
				<input type="text" name="zip" value=""><br><br>
				<label class= "field" for="footage">Square Footage:</label><br>
				<input type="text" name="footage" value=""><br><br>
				<label class= "field" for="roomDesc">Room Descriptions: </label><br>
				<textarea name="roomDesc" rows="10" cols="30" class="thousandChars"></textarea>
				<p class="remainingChars">Characters remaining: 1000</p>
				<br>
				<label class= "field" for="num_bedrooms">Number of Rooms:</label><br>
				<input type="text" name="num_bedrooms" value=""><br><br>
				<label class= "field" for="num_bathrooms">Number of Bathrooms:</label><br>
				<input type="text" name="num_bathrooms" value=""><br><br>
				<label class= "field" for="localDesc">Location Description: </label><br>
				<textarea name="localDesc" rows="10" cols="30" class="thousandChars"></textarea>
				<p class="remainingChars">Characters remaining: 1000</p>
				<br>
				<label class= "field" for="agent_only_info">Agent-Only Information: </label><br>
				<textarea name="agent_only_info" rows="10" cols="30" class="threeHundredChars"></textarea>
				<p class="remainingChars">Characters remaining: 300</p>
				<br>
				<input type="submit" value="Continue">
				<input type="reset">
			</fieldset>
		</form>
	</div>
	<br/>
	<?php include "../footer.php";  ?>
</body>
</html>
