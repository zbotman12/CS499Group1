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
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
	<div class="container-fluid">
	  <h2>Showings for <?php echo GetData('address', 'Listings') . ", " . GetData('city', 'Listings') . ", " . GetData('state', 'Listings');?></h2>
	  <a class="btn btn-default paragon" href="/Showing Schedule/newShowingDisplay.php?MLS=<?php echo $_GET['MLS']; ?>">Add A Showing</a>
	  <a class="btn btn-default paragon" href="/Listing/detailedListingDisplay.php?MLS=<?php echo $_GET['MLS']; ?>">View Listing</a>
      <button type="button" class="btn btn-default paragon" data-toggle="modal" data-target="#myModal" data-backdrop="false">Send Email</button>
         
      <!-- Modal Window here -->
      <div class="container">
        <div class="row">

        <!--Button trigger for modal--> 
        <!-- <button type="button" class="btn btn-default paragon" data-toggle="modal" data-target="#myModal">Send Email</button> -->
         
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
				if( GetShowingData('is_house_vacant', $key) == 1){
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
			  echo "<td class='text-center'><a class='glyphicon glyphicon-remove' href='/Helpers/Showing Schedule/deleteShowingHandle.php?MLS=" . $_GET['MLS'] . "&showing_id=" . GetShowingData('showing_id', $key) . "'></a></td>";
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
