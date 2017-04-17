<?php 
  //Check and make sure we have an active session. If not we need one so send the user to the login page.
  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
   ?>      
<!DOCTYPE html>
<html>
<head>
	<link
	href=formattingFile.css
	type="text/css"
	rel="stylesheet">
	
	 <link
    href="/js/crayJS/jquery-ui.min.css"
    type="text/css"
    rel="stylesheet">
    <body>
	<script>
		$(document).ready(function() {
			$(".thousandChars").keyup(function(){
			  $(this).next().text("Characters remaining: " + (1000 - $(this).val().length));
				if ($(this).val().length > 1000) {
					$(this).next().css("color", "red");
				} else {
					$(this).next().css("color", "inherit");
				}
			});
			$(".threeHundredChars").keyup(function(){
			  $(this).next().text("Characters remaining: " + (300 - $(this).val().length));
				if ($(this).val().length > 300) {
					$(this).next().css("color", "red");
				} else {
					$(this).next().css("color", "inherit");
				}
			});
		});


               
	</script>

	<!-- <meta charset="UTF-8"> -->
	<title>
		Your listings
	</title>
</head>

<body>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>

   <script type="text/javascript" src="/js/crayJS/jquery-ui.js"></script>
   <script type="text/javascript">
    $(function() {
                var availableTags = [ "AK","AL","AR","AZ","CA","CO","CT","DE","FL","GA","HI","IA","ID","IL","IN","KS","KY","LA","MA","MD","ME","MI","MN","MO","MT","NC","ND","NE","NH","NJ","NM","NV","NY","OH","OK","OR","PA","RI","SC","SD","TN","TX","UT","VA","VT","WA","WI","WV","WY"];
                $('#state').autocomplete({
                source: availableTags,
                change: function (event, ui) {
                        if(!ui.item){
                            $('#state').val("");
                        }
                }
                });
            });
   </script>

	<!-- action_page.php is a php file that handles the submitted input --> 
	<div class="container-fluid">
		<form action="/Helpers/Listing/createListingHandle.php" method="post" enctype="multipart/form-data">
			<fieldset>
				<h2>Listing Information</h2>
				<hr/>
				<label class= "field" for="price">List Price:</label><br>
				<input type="text" name="price" value="" required><br><br>
				
				<label class= "field" for="city">City:</label><br>
				<input type="text" name="city" value="" required><br><br>
				
				<label class= "field" for="state">State (Postal Code):</label><br>
				<input type="text" id="state" name="state" placeholder="Select State" value="" required><br><br>
				
				<label class= "field" for="zip">Zip:</label><br>
				<input type="text" name="zip" value="" required><br><br>
				
				<label class= "field" for="address">Address:</label><br>
				<input type="text" name="address" value="" required><br><br>
				
				<label class= "field" for="footage">Square Footage:</label><br>
				<input type="text" name="footage" value="" required><br><br>
				
				<label class= "field" for="num_bedrooms">Number of Rooms:</label><br>
				<input type="text" name="num_bedrooms" value=""><br><br>
				
				<label class= "field" for="num_bathrooms">Number of Bathrooms:</label><br>
				<input type="text" name="num_bathrooms" value=""><br><br>
				
				<label class= "field" for="desc">Description:</label><br>
				<textarea name="desc" rows="10" cols="30" class="thousandChars"></textarea>
				<p class="remainingChars">Characters remaining: 1000</p>
				
				<label class= "field" for="roomDesc">Room Descriptions:</label><br>
				<textarea name="roomDesc" rows="10" cols="30" class="thousandChars"></textarea>
				<p class="remainingChars">Characters remaining: 1000</p>
				
				<label class= "field" for="localDesc">Location Description:</label><br>
				<textarea name="localDesc" rows="10" cols="30" class="thousandChars"></textarea>
				<p class="remainingChars">Characters remaining: 1000</p>
				<br><br>
	
				<label class= "field" for="agent_only_info">Agent-Only Information:</label><br>
				<textarea name="agent_only_info" rows="10" cols="30" class="threeHundredChars"></textarea>
				<p class="remainingChars">Characters remaining: 300</p>
				<br><br>

				<input type="submit" value="Continue">
				<input type="reset">
			</fieldset>
		</form>
	</div>
	<br/>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
</html>
