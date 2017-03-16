<!DOCTYPE html>
<html>
    <!-- ISSUE: LINE 18, 154 - change showing_id to $_GET['showing_id'] --> 
    <head>  
        <link
            href=formattingFileShowingSchedule.css
            type="text/css"
            rel="stylesheet">
        <!-- <meta charset="UTF-8"> -->
        <title>Edit Listing</title>

        <?php 
            include "../DBTransactor/DBTransactorFactory.php";

            $showings = DBTransactorFactory::build("Listings");

            //$cond= array("showing_id"=> 1);  //We had $_GET['showing_id']
            $data = null;
            // Set Listings_MLS_number equal to whatever info we pass in instead of 1
            if ($result = $showings->select(['*'], ["MLS_number" => 1])) { //$_GET['MLS']
                if (count($result) == 1) {
                    $data = current($result);
                }
            } else {
                echo "There are multiple listings with same MLS number. Contact database administrator. <br/>";
            }
        ?>
    </head>

    <body>
        <!-- action_page.php is a php file that handles the submitted input --> 
        <form action="editListingDataHandle.php" method="post" enctype="multipart/form-data">
            <fieldset>
            <legend>Listing Information</legend> <br><br>

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
            
            <label class= "field" for="room_desc">Room Descriptions:</label><br>
            <textarea name="room_desc" rows="10" cols="30"><?php echo $data['room_desc']; ?> </textarea><br>
            
            <label class= "field" for="listing_desc">Description:</label><br>
            <textarea name="listing_desc" rows="10" cols="30"><?php echo $data['listing_desc']; ?> </textarea><br><br>
            
            <label class= "field" for="additional_info">Location Description:</label><br>
            <textarea name="additional_info" rows="10" cols="30"><?php echo $data['additional_info']; ?> </textarea><br><br>
            
            <label class= "field" for="agent_only_info">Alarm Information:</label><br>
            <input type="text" name="agent_only_info" value="<?php echo $data['agent_only_info']; ?>"><br><br>
            
            <input type="submit" value="Continue">
            <input type="reset">
            </fieldset>
        </form>
    </body>
</html>