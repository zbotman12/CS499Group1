<?php
  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/dataRetriever.php";
  $listings = DBTransactorFactory::build("Listings");
  $showings = DBTransactorFactory::build("Showings");

  $showingsArray = $showings->select(['*'], ['showing_agent_id' => $_SESSION['number']]);
?>

<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
  <style>
  td > .glyphicon
  {
  	font-size: 20px;
  }
  td > .glyphicon:hover
  {
  	text-decoration: none;
  	font-size: 20px;
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
  <title>Showings for <?php echo $_SESSION['name']; ?></title>
	<?php
		include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php";
		include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/deleteModal.php";
	?>
	<div class="container-fluid">
	  <h2>Showings for <?php echo $_SESSION['name']; ?></h2>
    <!--<a class="btn btn-default paragon" href="/Listing/detailedListingDisplay.php?MLS=<?php echo $_GET['MLS']; ?>">View Listing</a>-->

<div class="table-responsive">
	  <table class="table table-hover">
		<thead>
		  <tr>
			<th class="text-center">Date</th>
			<th class="text-center">Start Time</th>
			<th class="text-center">End Time</th>
			<th class="text-center">Vacant</th>
			<th class="text-center">Customer Name</th>
			<th class="text-center">MLS Number</th>
			<th class="text-center">Address</th>
			<th class="text-center">Lockbox Code</th>
			<th class="text-center">Edit</th>
      <th class="text-center">View Listing</th>
			<th class="text-center">Leave Feedback</th>
			<th class="text-center">Delete</th>
		  </tr>
		</thead>
		<tbody>
		  <?php
			foreach ($showingsArray as $showing_id => $array)
			{
        $currentListing = current($listings->select(['*'],['MLS_number' => $array['Listings_MLS_number']]));
			  echo "<tr>";
			  echo "<td class='text-center'>" . date( "F dS\\, Y", strtotime($array['start_time'])) . "</td>";
				echo "<td class='text-center'>" . date( "g\\:i A", strtotime($array['start_time']))  . "</td>";
				echo "<td class='text-center'>" . date( "g\\:i A", strtotime($array['end_time']))  . "</td>";
				if($array['is_house_vacant'] == 0){
					echo "<td class='text-center'>True</td>";
				}else{
					echo "<td class='text-center'>False</td>";
				}
				echo "<td class='text-center'>" . $array['customer_first_name'] . " " . $array['customer_last_name'] . "</td>";
				echo "<td class='text-center'>" . $currentListing['MLS_number'] . "</td>";
				echo "<td class='text-center'>" . $currentListing['address'] . ", " . $currentListing['city'] . ", " . $currentListing['state'] . ", " . $currentListing['zip'] . "</td>";
				echo "<td class='text-center'>" . $array['lockbox_code'] . "</td>";
				echo "<td class='text-center'><a class='glyphicon glyphicon-pencil' href='/Showing Schedule/editShowingDisplay.php?MLS=" . $array['Listings_MLS_number'] . "&showing_id=" . $showing_id . "'></a></td>";
        echo "<td class='text-center'><a class='glyphicon glyphicon-home' href='/Listing/detailedListingDisplay.php?MLS=" . $array['Listings_MLS_number'] . "'></a></td>";
			  echo "<td class='text-center'><a class='glyphicon glyphicon-book' href='/Showing Schedule/feedbackDisplay.php?MLS=" . $array['Listings_MLS_number'] . "&showing_id=" . $showing_id . "'></a></td>";
  			  echo "<td class='text-center'><a data-id='A ". $showing_id . "' data-toggle='modal' data-target='#myDeleteModal' data-backdrop='false' class='deleteShowingsButton glyphicon glyphicon-remove'></a></td>";
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