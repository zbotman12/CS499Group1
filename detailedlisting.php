<?php
    session_start();
    include "DBTransactor/DBTransactorFactory.php";

    function GetListingArray()
    { 
        if(!isset($_GET['MLS']))
        {
            echo "ERROR: You are trying to view a detailed listing without an MLS number in the URL.";
            exit();
        }

        $listings = DBTransactorFactory::build("Listings");

        if($ListingArray = $listings->select(['*'], ['MLS_number' => $_GET['MLS']]))
        {
            return $ListingArray[$_GET['MLS']];
        } else {
            echo "Error: Could not find MLS number in database. <br>" . mysqli_error($conn);
            return null;
        }
    }

    function GetAgentArray()
    { 
        $listingArray = GetListingArray();
        $Agents = DBTransactorFactory::build("Agents");

        if($agentArray = $Agents->select(['*'], ['agent_id' => $listingArray['Agents_listing_agent_id']]))
        {
            return $agentArray[$listingArray['Agents_listing_agent_id']];
        } else {
            echo "Error: Could not find listing agent in database. <br>" . mysqli_error($conn);
            return null;
        }
    }

    function GetAgencyArray()
    { 
        $agentArray = GetAgentArray();
        $Agencies = DBTransactorFactory::build("Agencies");

        if($agencyArray = $Agencies->select(['*'], ['agency_id' => $agentArray['Agencies_agency_id']]))
        {
            return $agencyArray[$agentArray['Agencies_agency_id']];
        } else {
            echo "Error: Could not find MLS number in database. <br>" . mysqli_error($conn);
            return null;
        }
    }

    function GetData($index, $table)
    {
        switch ($table) 
        {   
            case 'Listings' : $Array = GetListingArray(); break;
            case 'Agents'   : $Array = GetAgentArray(); break;
            case 'Agencies' : $Array = GetAgencyArray(); break;
            default         : return null;
        }

        if($Array != null && count($Array) > 0)
        {
            return $Array[$index];
        } 
    }

    function GetFilePathArray()
    { 
        if(!isset($_GET['MLS']))
        {
            echo "ERROR: You are trying to view a detailed listing without an MLS number in the URL.";
            exit();
        }
        $FilePathArray = null;
        $dir = "Listing/photos/" .  $_GET['MLS'] . "/";
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
    <link href="style/detailedListing.css" rel="stylesheet">
    <script src="js/jquery-1.11.3.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="header row">
        <h1 class="text-center">
            <?php
                echo GetData('address', 'Listings') . ", ";
                echo GetData('city', 'Listings') . ", " . GetData('state', 'Listings') . ", " . GetData('zip', 'Listings');
            ?>
        </h1>
    </div>
    <div class="row topRow">
        <div class="col-md-6">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                  <?php
                        $active_item = "class='active'";
                        $count = 0;
                        foreach (GetFilePathArray() as $filepath)
                        {
                            echo "<li data-target='#myCarousel' data-slide-to='" . $count . "' " . $active_item . "></li>";
                            $active_item = "";
                            $count = $count + 1;
                        }
                    ?>
              </ol>

              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                  <?php
                        $active_item = " active";
                        foreach (GetFilePathArray() as $filepath)
                        {
                            echo "<div class='item" . $active_item . "'>";
                            echo "<img class='d-block center-block CarouselImg' style='' src='" . $filepath . "' alt='HouseImage'></div>";
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

<!-- BASIC INFORMATION PANEL -->
        <div class="col-md-6 infoPanel">
            Listing Agent:
            <br>
            <div  class="textbox">
                <?php 
                    echo GetData('first_name', 'Agents') . " " . GetData('last_name', 'Agents') . "<br>";
                    echo GetData('agent_phone_number', 'Agents') . "<br>";
                    echo GetData('email', 'Agents') . "<br>";
                ?>
            </div>
            <br>
            Listing Company:
            <br>
            <div  class="textbox">
                <?php 
                    echo GetData('company_name', 'Agencies') . "<br>";
                    echo GetData('address', 'Agencies') . "<br>";
                    echo GetData('city', 'Agencies') . ", " . GetData('state', 'Agencies') . ", " . GetData('zip', 'Agencies'). "<br>";
                    echo GetData('agency_phone_number', 'Agencies');
                ?>
            </div>
            <br>
            Square Footage:
            <br>
            <div  class="textbox">
            <?php echo GetData('square_footage', 'Listings');?>
            </div>
            <br>
            Bedrooms:
            <br>
            <div  class="textbox">
            <?php echo GetData('number_of_bedrooms', 'Listings');?>
            </div>
            <br>
            Bathrooms:
            <br>
            <div  class="textbox">
            <?php echo GetData('number_of_bathrooms', 'Listings');?>
            </div>
        </div>
    </div>

    <div class="row">
<!-- DESCRIPTION PANEL -->
        <div class="col-md-6">
            Room Descriptions:
            <br>
            <div  class="textbox">
            <?php echo "<pre>" . GetData('room_desc', 'Listings') . "</pre>";?>
            </div>
            <br>
            Listing Description:
            <br>
            <div  class="textbox">
            <?php echo "<pre>" . GetData('listing_desc', 'Listings')  . "</pre>";?>
            </div>
            <br>
            Additional Info:
            <br>
            <div  class="textbox">
            <?php echo "<pre>" . GetData('additional_info', 'Listings')  . "</pre>";?>
            </div>
            <br>
        </div>

<!-- AGENT ONLY INFO PANEL -->
        <div class="col-md-6">
            <?php
                if(!empty($_SESSION['name']))
                {   
                    echo "Agent Only Info:<br>"; 
                    echo "Alarm Information:<br>";
                    echo "<pre>" . GetData('agent_only_info', 'Listings')  . "</pre>";
                    echo "Listing Agent Email Adress:<br>";
                    
                }
            ?>
        </div>
    </div>
</div>
</body> 
</html>