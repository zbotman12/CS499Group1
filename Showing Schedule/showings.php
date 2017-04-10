<?php
  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/dataRetriever.php";
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
  .glyphicon
  {
  	font-size: 20px;
  }
  .glyphicon:hover
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
  <title>Showings for <?php echo GetData('address', 'Listings') . ", " . GetData('city', 'Listings') . ", " . GetData('state', 'Listings');?></title>
	<?php
          include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; 
          include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/deleteModal.php";
          include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/emailModal.php";
  ?>
	<div class="container-fluid">
	  <h2>Showings for <?php echo GetData('address', 'Listings') . ", " . GetData('city', 'Listings') . ", " . GetData('state', 'Listings');?></h2>
	  <a class="btn btn-default paragon" href="/Showing Schedule/newShowingDisplay.php?MLS=<?php echo $_GET['MLS']; ?>">Add A Showing</a>
	  <a class="btn btn-default paragon" href="/Listing/detailedListingDisplay.php?MLS=<?php echo $_GET['MLS']; ?>">View Listing</a>
    <button type="button" class="btn btn-default paragon" data-toggle="modal" data-target="#myModal" data-backdrop="false">Send Email</button>

<div class="table-responsive">
	  <table class="table table-hover">
		<thead>
		  <tr>
			<th class="text-center">Date</th>
			<th class="text-center">Start Time</th>
			<th class="text-center">End Time</th>
			<th class="text-center">Vacant</th>
			<th class="text-center">Customer Name</th>
			<th class="text-center">Showing Agent</th>
			<th class="text-center">Showing Agency</th>
			<th class="text-center">Lockbox Code</th>
			<th class="text-center">Edit</th>
			<th class="text-center">Leave Feedback</th>
			<th class="text-center">Delete</th>
		  </tr>
		</thead>
		<tbody>
		  <?php
			foreach ((array)GetShowingsArrays() as $key => $value)
			{
			  $agentInfo=GetAgentandCompanyName(GetShowingData('showing_agent_id', $key));
			  
				//(RYAN): We may want to format these dates and times better.
			  echo "<tr>";
			  echo "<td class='text-center'>" . date( "F dS\\, Y", strtotime(GetShowingData('start_time', $key))) . "</td>";
				echo "<td class='text-center'>" . date( "g\\:i A", strtotime(GetShowingData('start_time', $key))) . "</td>";
				echo "<td class='text-center'>" . date( "g\\:i A", strtotime(GetShowingData('end_time', $key))) . "</td>";
				if( GetShowingData('is_house_vacant', $key) == 0){
					echo "<td class='text-center'>True</td>";
				}else{
					echo "<td class='text-center'>False</td>";
				}
				echo "<td class='text-center'>" . GetShowingData('customer_first_name', $key) . " " . GetShowingData('customer_last_name', $key) . "</td>";
				echo "<td class='text-center'>" . $agentInfo["full_name"] . "</td>";
				echo "<td class='text-center'>" . $agentInfo["company_name"] . "</td>";
				echo "<td class='text-center'>" . GetShowingData('lockbox_code', $key) . "</td>";
				echo "<td class='text-center'><a class='glyphicon glyphicon-pencil' href='/Showing Schedule/editShowingDisplay.php?MLS=" . $_GET['MLS'] . "&showing_id=" . GetShowingData('showing_id', $key) . "'></a></td>";
			  echo "<td class='text-center'><a class='glyphicon glyphicon-book' href='/Showing Schedule/feedbackDisplay.php?MLS=" . $_GET['MLS'] . "&showing_id=" . GetShowingData('showing_id', $key) . "'></a></td>";
			  echo "<td class='text-center'><a data-id='S ". $key . "' data-toggle='modal' data-target='#myDeleteModal' data-backdrop='false' class='deleteShowingsButton glyphicon glyphicon-remove'></a></td>";
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