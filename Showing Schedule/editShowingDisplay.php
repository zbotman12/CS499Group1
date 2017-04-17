<!DOCTYPE html> 
<html>
<head>	
	<link
		href=/style/formattingFileShowingSchedule.css
		type="text/css"
		rel="stylesheet">
	<!-- <meta charset="UTF-8"> -->
	<title>Edit Showing</title>
	<?php 
		include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/goodAgents.php";
		//include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/Showing Schedule/dataFormat.php";
		//include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
		$previous_data_array=getPreviousData();
		$formatted_info = getDefinedAgentInfo($previous_data_array["SA_id"]);
	?>
	<script src="/js/dateFilter.js"></script>
	<link
		href="/js/crayJS/jquery-ui.min.css"
		type="text/css"
		rel="stylesheet">
		
	<style>
		#scheduleForm {
			padding: 10px;
		}
		
		.form-group {
			font-family: sans-seriff;
		}
		
		input {
			width: auto;
		}
		
		.timeSelect {
			display: inline-block;
		}
	</style>
</head>
<body>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
	<script type="text/javascript" src="/js/crayJS/jquery-ui.js"></script>
	<script type="text/javascript">
		$(function(){
			$( '#date' ).datepicker({ minDate: 0 });
		});

		$(function() {
			var availableTags =<?php echo json_encode($formatted_info); ?>;
			$('#selectSAgent').autocomplete({
			source: availableTags,
			change: function (event, ui) {
				if(!ui.item){
					$('#selectSAgent').val("");
				}
			}
			});
		});
	</script>
	<div class="container-fluid">
		<h2>Edit Showing</h2>
		<hr/>
		
		<form name="scheduleForm" action="/Helpers/Showing Schedule/editShowingDataHandle.php" method="post">
			<div class="form-group">
				<label for="selectSAgent"><b>Enter/Select Showing Agent:</b></label>
				<input class="selectAgent" id="selectSAgent" name='SAgent' placeholder="Enter text here.." value="<?php echo $formatted_info[0];?>" required>
				<br/>
				
				<label><b>Start Time:</b></label>
				<span class="timeSelect">
					<select name='startHour'>
						<option value="<?php echo $previous_data_array["startHour"]; ?>"><?php echo $previous_data_array["startHour"]; ?></option>
						<?php 
							for($x=1; $x<=12; $x++){
								if(intval($previous_data_array["startHour"]) != $x)
								{
									echo "<option value=\"".$x."\">".$x."</option>";
								}
							}
						?>
					</select>
					<select name='startMin'>
						<option value="<?php echo $previous_data_array["startMin"]; ?>"><?php echo $previous_data_array["startMin"]; ?></option>
						<?php 
							for($x=0; $x<=45; $x+=15){
								if($x==0)
								{
									$str=":00";
								}else{
									$str= ":".$x;
								}
								if($previous_data_array["startMin"] != $str)
								{
									if($x==0)
									{
										echo "<option value=\":".$x."0\">:".$x."0</option>";
									}
									else
									{
										echo "<option value=\":".$x."\">:".$x."</option>";
									}
								}
							}
						?>
					</select>
					<select name='startTime'>
						<option value="<?php echo $previous_data_array["startCycle"]; ?>"><?php echo $previous_data_array["startCycle"]; ?></option>
						<?php 
							if($previous_data_array["startCycle"] == "PM")
							{
								echo "<option value=\"AM\">AM</option>";
							}else{
								echo "<option value=\"PM\">PM</option>";
							}
						?>
					</select>
				</span>
				<br/>
				
				<label><b>End Time:</b></label>
				<span class="timeSelect">
					<select name='endHour'>
						<option value="<?php echo $previous_data_array["endHour"]; ?>"><?php echo $previous_data_array["endHour"]; ?></option>
						<?php 
							for($x=1; $x<=12; $x++){
								if(intval($previous_data_array["endHour"]) != $x)
								{
									echo "<option value=\"".$x."\">".$x."</option>";
								}
							}
						?>
					</select>
					<select name='endMin'>
						<option value="<?php echo $previous_data_array["endMin"]; ?>"><?php echo $previous_data_array["endMin"]; ?></option>
						<?php 
							for($x=0; $x<=45; $x+=15){
								if($x==0)
								{
									$str=":00";
								}else{
									$str= ":".$x;
								}
								if($previous_data_array["endMin"] != $str)
								{
									if($x==0)
									{
										echo "<option value=\":".$x."0\">:".$x."0</option>";
									}
									else
									{
										echo "<option value=\":".$x."\">:".$x."</option>";
									}
								}
							}
						?>
					</select>
					<select name='endTime'>
						<option value="<?php echo $previous_data_array["endCycle"]; ?>"><?php echo $previous_data_array["endCycle"]; ?></option>
						<?php 
							if($previous_data_array["endCycle"] == "PM")
							{
								echo "<option value=\"AM\">AM</option>";
							}else{
								echo "<option value=\"PM\">PM</option>";
							}
						?>
					</select>
				</span>
				<br/>
				
				<label><b>Date (MM/DD/YYYY):</b></label> 
				<input type="text" name="date" id="date" value="<?php echo $previous_data_array["date"]; ?>" required>
				<br/>
				<label><b>Customer First Name:</b></label>
				<input type="text" name="fname" value="<?php echo $previous_data_array["fname"]; ?>"><br>
				
				<label><b>Customer Last Name:</b></label>
				<input type="text" name="lname" value="<?php echo $previous_data_array["lname"]; ?>"><br/>
				
				<label><b>Lock Box Code:</b></label>
				<input type="text" name="code" value="<?php echo $previous_data_array["code"]; ?>"><br/>
				
				<label><b>Is home occupied?</b></label>
				<select name='occupy'>
				<option value=<?php echo $previous_data_array["occupied"]; ?>><?php echo $previous_data_array["tempOccupy"]; ?></option>
				<?php 
					if($previous_data_array["occupied"] == 1)
					{
						echo "<option value=0>No</option>";
					}else{
						echo "<option value=1>Yes</option>";
					}
				?>
				</select><br/>
				
				<input type="hidden" name="showing_id" value="<?php echo $_GET['showing_id'];?>">
				<input type="hidden" name="MLS" value="<?php echo $_GET['MLS']; ?>">
				<input type="hidden" name="original_SA" value= "<?php echo $previous_data_array["SA_id"];?>">
				<br/>
				
				<input type="submit" value="Submit" name="Submit" onClick = "return isValid()" class="btn btn-default">
			</div>
		</form>
	</div>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
</html>
