<?php
  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/dataRetriever.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Showings for <?php echo GetData('address', 'Listings') . ", " . GetData('city', 'Listings') . ", " . GetData('state', 'Listings');?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
	<div class="container-fluid">
	  <h2>Showings for <?php echo GetData('address', 'Listings') . ", " . GetData('city', 'Listings') . ", " . GetData('state', 'Listings');?></h2>
	  <table class="table table-hover table-responsive">
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
		  	foreach ((array) GetShowingsArrays() as $key => $value)
			{
				//(RYAN): We may want to format these dates and times better.
			  echo "<tr>";
			  echo "<td class='text-center'>" . date( "F dS\\, Y", strtotime(GetShowingData('start_time', $key))) . "</td>";
				echo "<td class='text-center'>" . date( "g\\:i A", strtotime(GetShowingData('start_time', $key))) . "</td>";
				echo "<td class='text-center'>" . date( "g\\:i A", strtotime(GetShowingData('end_time', $key))) . "</td>";
				if( GetShowingData('is_house_vacant', $key) == 1){
					echo "<td class='text-center'>True</td>";
				}else{
					echo "<td class='text-center'>False</td>";
				}
				echo "<td class='text-center'>" . GetShowingData('customer_first_name', $key) . " " . GetShowingData('customer_last_name', $key) . "</td>";
				echo "<td class='text-center'>" . GetShowingData('showing_agent_name', $key) . "</td>";
				echo "<td class='text-center'>" . GetShowingData('showing_agent_company', $key) . "</td>";
				echo "<td class='text-center'>" . GetShowingData('lockbox_code', $key) . "</td>";
				echo "<td class='text-center'><a href='/Showing Schedule/editShowingDisplay.php?MLS=" . $_GET['MLS'] . "&showing_id=" . GetShowingData('showing_id', $key) . "'>[pencil]</a></td>";
			  echo "<td class='text-center'><a href=''>[notepad]</a></td>";
			  echo "<td class='text-center'><a href='/Helpers/Showing Schedule/deleteShowingHandle.php?MLS=" . $_GET['MLS'] . "&showing_id=" . GetShowingData('showing_id', $key) . "'>[x]</a></td>";
			  echo "</tr>";
			}
			?>
		</tbody>
	  </table>
	  <a class="btn btn-default" href="/Showing Schedule/newShowingDisplay.php?MLS=<?php echo $_GET['MLS']; ?>">Add A Showing</a>
	  <a class="btn btn-default" href="/Listing/detailedListingDisplay.php?MLS=<?php echo $_GET['MLS']; ?>">View Listing</a>
	</div>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/footer.php"; ?>
</body>
</html>
