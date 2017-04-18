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
		//include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/goodAgents.php";
		//include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/Showing Schedule/dataFormat.php";
		//include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
		include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/Showing Schedule/dataFormat.php";
		$previous_data_array=getPreviousData($_POST['showing_id']);
		$beginTime=$previous_data_array["startHour"].$previous_data_array["startMin"].$previous_data_array["startCycle"];
		$closeTime=$previous_data_array["endHour"].$previous_data_array["endMin"].$previous_data_array["endCycle"];
		$formatted_info = getFreeTimeUpdate($beginTime, $closeTime, $_POST['SAgent'], $_POST['date']);
    	$hours= array_keys($formatted_info);
    	error_log($previous_data_array["endCycle"],0);
    	if($previous_data_array["startHour"]=="0")
    	{
    		$previous_data_array["startHour"]="12";
    		
    	}
		
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
	
	<div class="container-fluid">
		<h2>Edit Showing</h2>
		<hr/>
		<script type="text/javascript">
	var totalTimes= <?php echo json_encode($formatted_info); ?>;
	var hour_keys= <?php echo json_encode($hours); ?>;
</script>

<div class="availability">
	<b>Available Times For Showing Agent and Listing</b><br/>
	<?php
	
		for($x=0;$x<95;$x++)
		{
			$inc=1;
			$endVar="";
			if($formatted_info[$hours[$x]]==0 || $formatted_info[$hours[$x]]==3)
			{
				while($formatted_info[$hours[$x+$inc]]!=1 && ($inc+$x) < 95)
				{
					$inc++;
				}

				$endVar=$hours[$x+$inc];
				$endTimeH=substr($endVar,0,2);
				if(intval($endTimeH)>12)
				{
					$tempMin=substr($endVar,2,3);
					$endVar=intval($endTimeH)-12;
					if($endVar<10)
					{
						$endVar="0".$endVar.$tempMin." PM";
					}else{
						$endVar=$endVar.$tempMin." PM";
					}
				}
				else if(intval($endTimeH)==12)
				{
					$endVar=$endVar." PM";
				}
				else
				{
					$endVar=$endVar." AM";	
				}
				if($x>42)
				{
					$tempStr=substr($hours[$x],0,2);
					$tempMin=substr($hours[$x],2,3);
					if(intval($tempStr) != 12)
					{
						$tempStr=intval($tempStr)-12;
					}
					else
					{
						$tempStr=intval($tempStr);
					}
					if($tempStr<10){
						echo "<b>0".$tempStr.$tempMin." PM - ".$endVar."</b><br/>";
					}
					else{
					echo "<b>".$tempStr.$tempMin." PM - ".$endVar."</b><br/>";
					}
				}
				else
				{
					$tempStr=substr($hours[$x],0,2);
					
					if($tempStr=="00")
					{
						$tempMin=substr($hours[$x],2,3);
						echo "<b>12".$tempMin." AM - ".$endVar."</b><br/>";
					}
					else
					{
						echo "<b>".$hours[$x]." AM - ".$endVar."</b><br/>";
					}
				}

				while($formatted_info[$hours[$x+$inc]]!=3 && ($inc+$x) < 95)
				{
					$inc++;
				}
				$x=$x+$inc-1;
			}
		}

	?>


</div>
		<form name="scheduleForm" action="/Helpers/Showing Schedule/editShowingDataHandle.php" method="post">
			<div class="form-group">
				
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
				
			
  				<input type="hidden" name="date" value="<?php echo $_POST['date']; ?>">
  			<input type="hidden" name="occupy" value="<?php echo $_POST['occupy']; ?>">
  			<input type="hidden" name="fname" value="<?php echo $_POST['fname']; ?>">
  			<input type="hidden" name="lname" value="<?php echo $_POST['lname']; ?>">
  				<input type="hidden" name="code" value="<?php echo $_POST['code']; ?>">
				<input type="hidden" name="SAgent" value="<?php echo $_POST['SAgent']; ?>">
				<input type="hidden" name="showing_id" value="<?php echo $_POST['showing_id'];?>">
				<input type="hidden" name="MLS" value="<?php echo $_POST['MLS']; ?>">
				<input type="hidden" name="original_SA" value= "<?php echo $_POST['original_SA'];?>">
				<br/>
				
				<input type="submit" value="Submit" name="Submit" onClick="return isTimeValid(totalTimes, hour_keys)" class="btn btn-default">
			</div>
		</form>
	</div>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
</html>
