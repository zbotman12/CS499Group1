<?php
    session_start();
    function GetListingArray()
    { 
        include "dbconnect.php";
        //$_GET['MLS'] = 1; //Someone else send this to me later
        //Get the listing's record from the database via the MLS number
        if($ListingObj = mysqli_query($conn, "SELECT * FROM Listings WHERE MLS_number=" . $_GET['MLS'])) /*'$_GET['MLS']'*/
        {
            return $ListingObj->fetch_array();
        } else {
            echo "Error: Could not find MLS number in database. <br>" . mysqli_error($conn);
            return null;
        }
    }

    function GetData($index)
    {
        $ListingArray = GetListingArray();
        if($ListingArray != null && count($ListingArray) > 0)
        {
            return $ListingArray[$index];
        }   
    }

    function GetFilePathArray()
    { 
        $FilePathArray = null;
        $dir = "Listing/photos/1/";
        if (is_dir($dir))
        {
            if ($dh = opendir($dir))
            {
                while (($file = readdir($dh)) !== false)
                {
                    if(!is_dir($dir . $file) && exif_imagetype($dir . $file))
                    {
                        if($FilePathArray == null)
                        {
                            $FilePathArray = array($dir . $file);
                        } else {
                            array_push($FilePathArray, $dir . $file);
                        }
                    }
                }
                closedir($dh);
                return $FilePathArray;
            }
        }
    }
?>
<html>
    <head>
        <link href="style/bootstrap.min.css" rel="stylesheet">
        <link href="style/bootstrap.theme.min.css" rel="stylesheet">
        <link href="style/bootstrap.css" rel="stylesheet">
        <script src="js/jquery-1.11.3.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <style>
        pre {
            display: table;
            font-family: arial;
            white-space: pre-wrap;
            margin: 5px 10px;
            background-color: white;
            border: 0px;
        } 
    </style>
    <body>
        <h1>
            <?php
                echo GetData('address') . "<br>";
                echo GetData('city') . ", " . GetData('state') . ", " . GetData('zip');
            ?>
        </h1>
        <div class="col-md-6">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
              <?php
                    $active_item = " active";
                    foreach (GetFilePathArray() as $filepath)
                    {
                        echo "<div class='item" . $active_item . "'>";
                        echo "<img class='d-block center-block' style='' src='" . $filepath . "' alt='HouseImage'></div>";
                        $active_item = "";
                    }
                ?>
          </div>
          <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control left" aria-hidden="false"></span>
                <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control right" aria-hidden="false"></span>
                <span class="sr-only">Next</span>
          </a>
        </div>
        </div>

        <div class="col-md-6">
            Square Footage:
            <?php echo GetData('square_footage');?>
            <br>
            Bedrooms:
            <?php echo GetData('number_of_bedrooms');?>
            <br>
            Bathrooms:
            <?php echo GetData('number_of_bathrooms');?>
            <br>
            Room Descriptions:
            <?php echo "<pre>" . GetData('room_desc') . "</pre>";?>
            <br>
            Listing Description:
            <?php echo "<pre>" . GetData('listing_desc')  . "</pre>";?>
            <br>
            Additional Info:
            <?php echo "<pre>" . GetData('additional_info')  . "</pre>";?>
            <br>
            <?php
                if(!empty($_SESSION['name']))
                {
                    echo "Agent Only Info:"; 
                    echo "<pre>" . GetData('agent_only_info')  . "</pre>";
                }
            ?>
        </div>
    </body> 
</html>