<?php
     include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/dataRetriever.php";
     Hit();  
?>
<html>
<head>
    <link href="/style/bootstrap.min.css" rel="stylesheet">
    <link href="/style/bootstrap.css" rel="stylesheet">
    <link href="/style/Listing.css" rel="stylesheet">
    <script src="/js/jquery-1.11.3.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title> <?php echo GetData('address', 'Listings'); ?> </title>
</head>
<body>
<?php  
    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/emailModal.php";    
?>
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
                        
                        $directories = GetFilePathArray();
                        
                        //var_dump($directories);
                        if(is_array($directories)){
                            foreach ($directories as $filepath)
                            {
                                echo "<li data-target='#myCarousel' data-slide-to='" . $count . "' " . $active_item . "></li>";
                                $active_item = "";
                                $count = $count + 1;
                            }
                        }
                        else {
                            echo "<li data-target='#myCarousel' data-slide-to='" . $count . "' " . $active_item . "></li>";
                            $active_item = "";
                        }
                    ?>
              </ol>

              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                  <?php
                        $active_item = " active";
                        $directories = GetFilePathArray();

                        if (is_array($directories)) {
                            foreach ($directories as $filepath)
                            {
                                echo "<div class='item" . $active_item . "'>";
                                //echo $filepath;
                                echo "<img class='d-block center-block CarouselImg' src='" . $filepath . "' alt='HouseImage'></div>";
                                $active_item = "";
                            }  
                        } else {
                            echo "<div class='item" . $active_item . "'>";
                            //echo $_SERVER['DOCUMENT_ROOT'];
                            echo "<img class='d-block center-block CarouselImg' src='../Helpers/Images/noimage.png'" . " alt='HouseImage'></div>";
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
                    echo GetData('phone_number', 'Agents') . "<br>";
                    echo GetData('email', 'Agents') . "<br>";
                ?>
            <button type="button" class="btn btn-primary paragon" data-toggle="modal" data-target="#myModal" data-backdrop="false">Contact Me!</button>
            </div>
            <br>
            Listing Company:
            <br>
            <div  class="textbox">
                <?php 
                    echo GetData('company_name', 'Agencies') . "<br>";
                    echo GetData('address', 'Agencies') . "<br>";
                    echo GetData('city', 'Agencies') . ", " . GetData('state', 'Agencies') . ", " . GetData('zip', 'Agencies'). "<br>";
                    echo GetData('phone_number', 'Agencies');
                ?>
            </div>
            <br>
            Price:
            <div  class="textbox">
            <?php echo GetData('price', 'Listings');?>
            </div>
            Square Footage:
            <div  class="textbox">
            <?php echo GetData('square_footage', 'Listings');?>
            </div>
            Bedrooms:
            <div  class="textbox">
            <?php echo GetData('number_of_bedrooms', 'Listings');?>
            </div>
            Bathrooms:
            <div  class="textbox">
            <?php echo GetData('number_of_bathrooms', 'Listings');?>
            </div>
        </div>
    </div>

    <div class="row bottomRow">
<!-- DESCRIPTION PANEL -->
        <div class="col-md-6 infoPanel blueRowHeader">
            Room Descriptions:
            <br>
            <div  class="textbox">
            <?php echo "<pre class='blueRowPanel'>" . GetData('room_desc', 'Listings') . "</pre>";?>
            </div>
            <br>
            Listing Description:
            <br>
            <div  class="textbox">
            <?php echo "<pre class='blueRowPanel'>" . GetData('listing_desc', 'Listings')  . "</pre>";?>
            </div>
            <br>
            Additional Info:
            <br>
            <div  class="textbox">
            <?php echo "<pre class='blueRowPanel'>" . GetData('additional_info', 'Listings')  . "</pre>";?>
            </div>
            <br>
        </div>

<!-- AGENT ONLY INFO PANEL -->
        <div class="col-md-6 infoPanel">
            <?php
                if(!empty($_SESSION['name']))
                {  
                    echo "<div class='panel panel-default'>";
                        echo "<div class='panel-heading'>Agent Only Info:</div><br>";
                        echo "<div class='textbox panel-body'>";
                            echo "Agent Information:<br>";
                            echo "<pre>" . GetData('agent_only_info', 'Listings')  . "</pre><br>";
                            echo "<div class='row'>";
                                echo "<div class='col-sm-5 col-xs-5'> Hits (Today): " . GetData('daily_hit_count', 'Listings')  . "<br>";
                                echo "Hits (All-Time): " . GetData('hit_count', 'Listings')  . "</div>";
                                echo "<br/>";
                                echo "<a class='btn btn-primary col-sm-3 col-xs-3' style='padding: 10px;' href='/Showing Schedule/showings.php?MLS=" . $_GET['MLS'] . "'>Showings</a>";
                                echo "<a class='btn btn-primary col-sm-3 col-xs-3' style='padding: 10px; margin-left:10px;' href='../paperwork.php?MLS=" . $_GET['MLS'] . "'>Paperwork</a>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</div>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body> 
</html>
