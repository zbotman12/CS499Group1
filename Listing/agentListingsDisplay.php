<!--
    File: agentListingsDisplay.php
    Displays all agent listings.
-->

<?php
  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";
    
    $agents   = DBTransactorFactory::build("Agents");
    $listings = DBTransactorFactory::build("Listings");
    $agencies   = DBTransactorFactory::build("Agencies");

    //Must make this get agent id from current session
    $result = $agents->select(['*'], ["user_login" => $_SESSION['name']]);
    $agent  = current($result);

    //Select all listings that agent has available.
    $listingInfo = $listings->select(['*'], ["Agents_listing_agent_id" => $agent['agent_id']]);

    //Select all agents from the current agent's agency
    $agencyMembers = $agents->select(['agent_id'], ["Agencies_agency_id" => $agent['Agencies_agency_id']]);

    //remove the current agent from the agency list
    $listingInfoAgency = array();
    unset($agencyMembers[$agent['agent_id']]);
    //Build an array of all listings in the agency but not for this agent.
    foreach($agencyMembers as $agentid => $agentinfo)
    {
       $listingInfoAgency = array_merge($listingInfoAgency, $listings->select(['*'], ["Agents_listing_agent_id" => $agentid]));
    }

    $result = $agencies->select(['*'], ["agency_id" => $agent['Agencies_agency_id']]);
    $agency = current($result);


    //Setup Buttons
    $editListing  = "<td>" . "<form method='get' action='/Listing/editListingDisplay.php' class='text-center'>";
    $editListing1 = "<button type='submit' name='MLS' value='";
    $editListing2 = "' class='link-button'><div class='glyphicon glyphicon-pencil'></div></button></form></td>";

    $delListing   = "<td>" . "<form method='post' action='/Helpers/Listing/deleteListingHandle.php' class='text-center'>";
    $delListing1  = "<button type='submit' name='MLS_number' value='";
    $delListing2  = "'><div class='glyphicon glyphicon-remove'></div></button></form></td>";
     
    $view  = "<td>" . "<form method='get' action='/Listing/detailedListingDisplay.php' class='text-center'>";
    $view1 = "<button type='submit' name='MLS' value='";
    $view2 = "'><div class='glyphicon glyphicon-home'></div></form></td>";

    $showings = "<td>" . "<form method='get' action='/Showing Schedule/showings.php' class='text-center'>";
    $showings1 = "<button type='submit' name='MLS' value='";
    $showings2 = "'><div class='glyphicon glyphicon-eye-open'></div></form></td>";
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
  .paragon
  {
    color: #337ab7 !important;
    background-color: rgb(255, 204, 0) !important;
  }
  .paragon:hover
  {
    color: #23527c !important;
    background-color: rgb(255, 204, 0) !important;
  }
  </style>
</head>
<body>
<?php  
    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/deleteModal.php";
?>
<div class="container-fluid">
  <h2>Listings for <?php echo $agent['user_login']; ?></h2>

  <a href="/Listing/createListingDisplay.php" style="background-color: rgb(255, 204, 0)" class="btn">Add New Listing</a>           

  <div class="table-responsive">
  <table class="table table-hover  table-responsive">
    <thead>
      <tr>
        <th class='text-left'>Address</th>
        <th class='text-left'>City</th>
        <th class='text-left'>State</th>
        <th class='text-center'>View</th>
        <th class='text-center'>Showings</th>
        <th class='text-center'>Edit</th>
        <th class='text-center'>Delete</th>
      </tr>
    </thead>
    <tbody>
      <tr>
      <?php

          //Listings for the agent      
          foreach($listingInfo as $mls => $array) {
              echo "<tr>";
              echo "<td style='width:400px;'>" . $array['address'] . "</td>";
              echo "<td style='width:400px;'>" . $array['city']    . "</td>";
              echo "<td style='width:200px;'>" . $array['state']   . "</td>";

              //View Detailed Listing
              echo $view . $view1 . $mls . $view2; 
			  
			       //View Showings
			       echo $showings . $showings1 . $mls . $showings2; 

              //Edit Listing
              echo $editListing . $editListing1 . $mls . $editListing2;

              echo "<td class='text-center'><button data-toggle='modal' data-target='#myDeleteModal' data-backdrop='false'><span data-id='". $mls . "' class='deleteListingsButton glyphicon glyphicon-remove'></span></button></td>";
              echo "</tr>";
          }
      ?>
      </tr>
    </tbody>
  </table>
  </div>
  </div>
<div class="container-fluid">
  <h2>Listings for <?php echo $agency['company_name']; ?></h2>          

  <div class="table-responsive">
  <table class="table table-hover  table-responsive">
    <thead>
      <tr>
        <th class='text-left'>Address</th>
        <th class='text-left'>City</th>
        <th class='text-left'>State</th>
        <th class='text-center'>View</th>
        <th class='text-center'>Showings</th>
        <th class='text-center'>Edit</th>
        <th class='text-center'>Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php
          foreach($listingInfoAgency as $index => $array) {
              $mls = $array['MLS_number'];
              echo "<tr>";
              echo "<td style='width:400px;'>" . $array['address'] . "</td>";
              echo "<td style='width:400px;'>" . $array['city']    . "</td>";
              echo "<td style='width:200px;'>" . $array['state']   . "</td>";

              //View Detailed Listing
              echo $view . $view1 . $mls . $view2; 
        
             //View Showings
             echo $showings . $showings1 . $mls . $showings2; 

              //Edit Listing
              echo $editListing . $editListing1 . $mls . $editListing2;

              //Delete Listing
              echo "<td class='text-center'><button data-toggle='modal' data-target='#myDeleteModal' data-backdrop='false'><span data-id='". $mls . "'  class='deleteListingsButton glyphicon glyphicon-remove'></span></button></td>";
              echo "</tr>";
          }
      ?>
    </tbody>
  </table>
  </div>
</div>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
</html>
