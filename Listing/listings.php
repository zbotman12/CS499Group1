<!--
    File: Listings.php
    Displays all agent listings.
-->

<?php
    include "../sessioncheck.php";
    include "../DBTransactor/DBTransactorFactory.php";
    
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
</head>
<body>

<div class="container-fluid">
  <h2>Listings for <?php echo $agent['user_login']; ?></h2>            
  <form action='inputTest.php' class='inline'>
    <button type='submit' class='link-button'>Add New Listing</button>
  </form>
  <table class="table table-hover  table-responsive">
    <thead>
      <tr>
        <th>Address</th>
        <th>City</th>
        <th>State</th>
        <th>View</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <tr>
      <?php

          $editListing  = "<td>" . "<form method='post' action='editListingDisplay.php' class='inline'>";
          $editListing1 = "<button type='submit' name='MLS_number' value='";
          $editListing2 = "' class='link-button'>Edit</button></form></td>";

          $delListing   = "<td>" . "<form method='post' action='deleteListing.php' class='inline'>";
          $delListing1  = "<button type='submit' name='MLS_number' value='";
          $delListing2  = "'>Delete</button></form></td>";
           
          $view  = "<td>" . "<form method='get' action='../detailedlisting.php' class 'inline'>";
          $view1 = "<button type='submit' name='MLS' value='";
          $view2 = "'>View</a></form></td>";

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

              //View Listing
              //echo "<td>" . "<a class='btn btn-default' href='../detailedlisting.php?MLS='" . $_GET['MLS'] . "'>View</a></td>";
              echo $view . $view1 . $mls . $view2; 

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

</body>
</html>
