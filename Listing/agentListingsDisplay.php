<!--
    File: agentListingsDisplay.php
    Displays all agent listings.
-->

<?php
  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";
    
    $agents   = DBTransactorFactory::build("Agents");
    $listings = DBTransactorFactory::build("Listings");

    //Must make this get agent id from current session
    $result = $agents->select(['*'], ["user_login" => $_SESSION['name']]);
    $agent  = current($result);

    //Select all listings that agent has available.
    $listingInfo = $listings->select(['*'], ["Agents_listing_agent_id" => $agent['agent_id']])
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Listings for <?php echo $agent['user_login'];?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
    button {
     background:none!important;
     color: #337ab7 !important;
     border:none; 
     padding:0!important;
     font: inherit;
     font-size: 20px !important;
     cursor: pointer;
  }
  button:hover {
     background:none!important;
     color: #23527c !important;
     border:none; 
     padding:0!important;
     font: inherit;
     font-size: 20px !important;
     cursor: pointer;
  }
  </style>
</head>
<body>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
<div class="container-fluid">
  <h2>Listings for <?php echo $agent['user_login']; ?></h2>
  <!-- We need to change this-->
  <a href="/Listing/createListingDisplay.php" style="background-color: rgb(255, 204, 0)" class="btn">Add New Listing</a>           

  <div class="table-responsive">
  <table class="table table-hover  table-responsive">
    <thead>
      <tr>
        <th>Address</th>
        <th>City</th>
        <th>State</th>
        <th class='text-center'>View</th>
        <th class='text-center'>Showings</th>
        <th class='text-center'>Edit</th>
        <th class='text-center'>Delete</th>
      </tr>
    </thead>
    <tbody>
      <tr>
      <?php

          $editListing  = "<td>" . "<form method='get' action='/Listing/editListingDisplay.php' class='text-center'>";
          $editListing1 = "<button type='submit' name='MLS' value='";
          $editListing2 = "' class='link-button'><div class='glyphicon glyphicon-pencil'></div></button></form></td>";

          /*
          $delListing   = "<td>" . "<form method='post' action='/Helpers/Listing/deleteListingHandle.php' class='text-center'>";
          $delListing1  = "<button type='submit' name='MLS_number' value='";
          $delListing2  = "'>Delete</button></form></td>";
          */
          $delListing   = "<td>" . "<form method='post' action='../Helpers/Listing/deleteListingHandle.php' class='text-center'>";
          $delListing1  = "<button type='submit' name='MLS_number' value='";
          $delListing2  = "'><div class='glyphicon glyphicon-remove'></div></button></form></td>";
           
          $view  = "<td>" . "<form method='get' action='/Listing/detailedListingDisplay.php' class='text-center'>";
          $view1 = "<button type='submit' name='MLS' value='";
          $view2 = "'><div class='glyphicon glyphicon-home'></div></form></td>";
		  
		  $showings = "<td>" . "<form method='get' action='/Showing Schedule/showings.php' class='text-center'>";
          $showings1 = "<button type='submit' name='MLS' value='";
          $showings2 = "'><div class='glyphicon glyphicon-eye-open'></div></form></td>";

          /*
          $view  = "<td>" . "<a class='btn btn-default' href='../detailedlisting.php?MLS='";
          $view1 = "'>View</a></td>"; */
          
          /*
          $view  = "<td>" . "<a class='button' href='../detailedlisting.php?MLS='";
          $view1 = "' target='_blank'>View</a></td>";
          */          
          foreach($listingInfo as $mls => $array) {
              echo "<tr>";
              echo "<td>" . $array['address'] . "</td>";
              echo "<td>" . $array['city']    . "</td>";
              echo "<td>" . $array['state']   . "</td>";

              //View Detailed Listing
              //echo "<td>" . "<a class='btn btn-default' href='../detailedlisting.php?MLS='" . $_GET['MLS'] . "'>View</a></td>";
              echo $view . $view1 . $mls . $view2; 
			  
			  //View Showings
			  echo $showings . $showings1 . $mls . $showings2; 

              //Edit Listing
              echo $editListing . $editListing1 . $mls . $editListing2;

              //Delete Listing
              echo $delListing . $delListing1 . $mls . $delListing2;
              echo "</tr>";
          }
      ?>
      </tr>
    </tbody>
  </table>
  </div>
</div>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
</html>
