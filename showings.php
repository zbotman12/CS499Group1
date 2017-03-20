<?php
    include "dataretriever.php";
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

<div class="container-fluid">
  <h2>Showings for <?php echo GetData('address', 'Listings') . ", " . GetData('city', 'Listings') . ", " . GetData('state', 'Listings');?></h2>
  <a class="btn btn-default" href="./Showing Schedule/newShowingDisplay.php?MLS=<?php echo $_GET['MLS']; ?>">Add A Showing</a>    
  <table class="table table-hover  table-responsive">
    <thead>
      <tr>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Vacant</th>
        <th>Customer Name</th>
        <th>Showing Agent</th>
        <th>Showing Agency</th>
        <th>Lockbox Code</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <tr>
      <?php
      $count = 1;
        while ($count <= GetShowingsCount())
        {
        	//(RYAN): We may want to format these dates and times better.
    		echo "<td>" . GetShowingData('start_time', $count) . "</td>";
    		echo "<td>" . GetShowingData('end_time', $count) . "</td>";
    		if( GetShowingData('is_house_vacant', $count) == 1){
    			echo "<td>True</td>";
    		}else{
    			echo "<td>False</td>";
    		}
    		echo "<td>" . GetShowingData('customer_first_name', $count) . " " . GetShowingData('customer_last_name', $count) . "</td>";
    		echo "<td>" . GetShowingData('showing_agent_name', $count) . "</td>";
    		echo "<td>" . GetShowingData('showing_agent_company', $count) . "</td>";
    		echo "<td>" . GetShowingData('lockbox_code', $count) . "</td>";
    		echo "<td><a href='./Showing Schedule/editShowingDisplay.php?MLS=" . $_GET['MLS'] . "&showing_id=" . GetShowingData('showing_id', $count) . "'>[pencil]</a></td>";
    		$count = $count + 1;
        }
        ?>
      </tr>
    </tbody>
  </table>
</div>

</body>
</html>
