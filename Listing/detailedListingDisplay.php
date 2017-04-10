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
</head>
<body>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
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
            <button type="button" class="btn btn-default paragon" data-toggle="modal" data-target="#myModal" data-backdrop="false">Contact Me!</button>
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
                                echo "<div class='col-sm-9 col-xs-9'> Hits (Today): " . GetData('daily_hit_count', 'Listings')  . "<br>";
                                echo "Hits (All-Time): " . GetData('hit_count', 'Listings')  . "</div>";
                                echo "<a class='btn btn-default col-sm-3 col-xs-3' style='padding: 10px;' href='/Showing Schedule/showings.php?MLS=" . $_GET['MLS'] . "'>View Showings</a>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>

    <!--Begin Modal Window--> 
        <div class="modal fade left" id="myModal"> 
        <div class="modal-dialog"> 
        <div class="modal-content"> 
        <div class="modal-header"> 
        <h3 class="pull-left no-margin">Send message to agent</h3>
        <button type="button" class="close" data-dismiss="modal" title="Close"><span class="glyphicon glyphicon-remove"></span>
        </button> 
        </div> 

        <div class="modal-body">
            <!--Contact Form-->
            <form id="sendEmail" class="form-horizontal" role="form" method="post" action="/Helpers/Mail/emailFormHandler.php "> 
                <span class="required">* Required</span> 
                <div class="form-group"> 
                    <label for="name" class="col-sm-3 control-label">
                    <span class="required">*</span> Name:</label> 
                    <div class="col-sm-9"> 
                    <input type="text" class="form-control" id="name" name="name" placeholder="First &amp; Last" required> 
                    </div> 
                </div> 
                <div class="form-group"> 
                    <label for="email" class="col-sm-3 control-label">
                    <span class="required">*</span> Email: </label> 
                    <div class="col-sm-9"> 
                    <input type="email" class="form-control" id="email" name="email" placeholder="you@cs499Team1.com" required> 
                    </div> 
                </div> 
                <div class="form-group"> 
                    <label for="message" class="col-sm-3 control-label">
                    <span class="required">*</span> Message:</label> 
                    <div class="col-sm-9"> 
                    <textarea name="message" rows="4" required class="form-control" id="message" placeholder="Comments"></textarea> 
                    </div> 
                </div> 
                <div class="form-group"> 
                    <div class="col-sm-offset-3 col-sm-6 col-sm-offset-3"> 
                    <button type="submit" id="submit" name="submit" class="btn-lg btn-primary">Send</button> 
                    </div> 
                </div>
                <input type="hidden" name="MLS_number" value=" <?php echo $_GET['MLS'];?>"><br><br>
            <!--end Form-->
            </form>
        </div>

        <div class="modal-footer"> 
        <div class="col-xs-10 pull-left text-left text-muted"> 
        <small><strong>Privacy Policy:</strong>
        Please read our ParagonMLS privacy policy and terms of abuse.</small> 
        </div> 
        <button class="btn-sm close" type="button" data-dismiss="modal">Close</button> 

        </div> 
        </div> 
        </div> 
        </div>
        </div> 
        </div> 
</div>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body> 
</html>
