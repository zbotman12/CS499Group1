<!DOCTYPE html>
<?php
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/Showing Schedule/dataFormat.php";
	include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
    $formatted_info = getFreeTime($_POST['SAgent'], $_POST['date']);
    $hours= array_keys($formatted_info);
?>
<html>
<head>	
<link
	href="/style/formattingFileShowingSchedule.css"
	type="text/css"
	rel="stylesheet">
<title></title>
<script src="/js/dateFilter.js">
</script>
<link
	href="/js/crayJS/jquery-ui.min.css"
	type="text/css"
	rel="stylesheet">
</head>
<body>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/header.php"; ?>
<script type="text/javascript" src="/js/crayJS/jquery-ui.js"></script>

<script type="text/javascript">
	var totalTimes= <?php echo json_encode($formatted_info); ?>;
	var hour_keys= <?php echo json_encode($hours); ?>;
</script>

<div class="availability">
	<b>Available Times for Showing Agent and Listing</b><br/>
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

<div class="wholeForm">
<form name="scheduleForm" action="/Helpers/Showing Schedule/newShowingDataHandle.php" method="post">
	<div class= "timeStart"><label><b>Start Time:</b></label>
		<select name='startHour' id="Stime">
 			<?php 
 				for($x=1; $x<=12; $x++){
 					echo "<option value=\"".$x."\">".$x."</option>";
 				}

 			?>
		</select>
		<select name='startMin'>
			<option value=":00">:00</option>
 	    	<option value=":15">:15</option>
  	    	<option value=":30">:30</option>
 	    	<option value=":45">:45</option>
		</select>
		<select name='startTime'>
	    	<option value="AM">AM</option>
 	    	<option value="PM">PM</option>
		</select>
	</div>
	<br/>
	<div class= "timeEnd"><label><b>End Time:</b></label>
		<select name='endHour'>
 			<?php 
 				for($x=1; $x<=12; $x++){
 					echo "<option value=\"".$x."\">".$x."</option>";
 				}
 				
 			?>
		</select>
		<select name='endMin'>
			<option value=":00">:00</option>
 	    	<option value=":15">:15</option>
  	    	<option value=":30">:30</option>
 	    	<option value=":45">:45</option>
		</select>
		<select name='endTime' id="EAMFM">
	    	<option value="AM">AM</option>
 	   		<option value="PM">PM</option>
		</select>
	</div> 
	<br/>
  	<input type="hidden" name="MLS" value="<?php echo $_POST['MLS']; ?>">
  	<input type="hidden" name="SAgent" value="<?php echo $_POST['SAgent']; ?>">
  	<input type="hidden" name="date" value="<?php echo $_POST['date']; ?>">
  	<input type="hidden" name="occupy" value="<?php echo $_POST['occupy']; ?>">
  	<input type="hidden" name="fname" value="<?php echo $_POST['fname']; ?>">
  	<input type="hidden" name="lname" value="<?php echo $_POST['lname']; ?>">
  	<input type="hidden" name="code" value="<?php echo $_POST['code']; ?>">
  	<input style="margin: auto" class="button" type="submit" value="Submit" name="Submit" onClick="return isTimeValid(totalTimes, hour_keys)"/>
</form>
</div>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
</html>