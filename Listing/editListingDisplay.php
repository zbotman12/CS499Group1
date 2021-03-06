<!--
    File: editListingDisplay.php
    HTML form to edit Listing currently selected.
-->

<!DOCTYPE html>
<html>
    <!-- ISSUE: LINE 18, 154 - change showing_id to $_GET['showing_id'] --> 
    <head>  
        <link
            href=formattingFileShowingSchedule.css
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
        <title>Edit Listing</title>

        <?php 
            include "../DBTransactor/DBTransactorFactory.php";

            $listings = DBTransactorFactory::build("Listings");

            $data = null;
            if ($result = $listings->select(['*'], ["MLS_number" => $_GET['MLS']])) {
                //var_dump($_GET);
                //var_dump($result);
                if (count($result) == 1) {
                    $data = current($result);
                }
            } else {
                echo "There are multiple listings with same MLS number. Contact database administrator. <br/>";
            }
        ?>
    </head>

    <body>
        <?php include "../header.php" ?>
        <!-- action_page.php is a php file that handles the submitted input --> 
		<div class="container-fluid">
			<form action="editListing.php" method="get" enctype="multipart/form-data">
				<fieldset>
				<h2>Listing Information</h2>
				<hr/>
				<label class= "field" for="price">List Price:</label><br>
				<input type="text" name="price" value="<?php echo $data['price']; ?>"><br><br>

				<label class= "field" for="city">City:</label><br>
				<input type="text" name="city" value="<?php echo $data['city']; ?>"><br><br>
				
				<label class= "field" for="state">State:</label><br>
				<input type="text" name="state" value="<?php echo $data['state']; ?>"><br><br>
				
				<label class= "field" for="zip">Zip:</label><br>
				<input type="text" name="zip" value="<?php echo $data['zip']; ?>"><br><br>
				
				<label class= "field" for="address">Address:</label><br>
				<input type="text" name="address" value="<?php echo $data['address']; ?>"><br><br>
				
				<label class= "field" for="square_footage">Square Footage:</label><br>
				<input type="text" name="square_footage" value="<?php echo $data['square_footage']; ?>"><br><br>
				
				<label class= "field" for="number_of_bedrooms">Number of Rooms:</label><br>
				<input type="text" name="number_of_bedrooms" value="<?php echo $data['number_of_bedrooms']; ?>"><br><br>
				
				<label class= "field" for="number_of_bathrooms">Number of Bathrooms:</label><br>
				<input type="text" name="number_of_bathrooms" value="<?php echo $data['number_of_bathrooms']; ?>"><br><br>
				
				<label class= "field" for="listing_desc">Description:</label><br>
				<textarea name="listing_desc" rows="10" cols="30" class="thousandChars"><?php echo $data['listing_desc']; ?></textarea>
				<p class="remainingChars">Characters remaining: 1000</p>
				
				<label class= "field" for="room_desc">Room Descriptions:</label><br>
				<textarea name="room_desc" rows="10" cols="30" class="thousandChars"><?php echo $data['room_desc']; ?></textarea>
				<p class="remainingChars">Characters remaining: 1000</p>
				
				<label class= "field" for="additional_info">Location Description:</label><br>
				<textarea name="additional_info" rows="10" cols="30" class="thousandChars"><?php echo $data['additional_info']; ?></textarea>
				<p class="remainingChars">Characters remaining: 1000</p>
				
				<label class= "field" for="agent_only_info">Agent-Only Information:</label><br>
				<textarea name="agent_only_info" rows="10" cols="30" class="threeHundredChars"><?php echo $data['agent_only_info']; ?></textarea>
				<p class="remainingChars">Characters remaining: 300</p>
				
				<input type="hidden" name = "MLS" value=" <?php echo $_GET['MLS'];?>"><br><br>
				<input type="submit" value="Continue">
				<input type="reset">
				</fieldset>
			</form>
		</div>
		<br/>
        <?php include "../footer.php" ?>
    </body>
</html>
