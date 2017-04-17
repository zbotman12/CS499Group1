<!DOCTYPE html>
<?php
	//include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/Showing Schedule/dataFormat.php";
	//include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessionCheck.php";
    //$formatted_info = getAgentInfo();
?>
<html> 
<head>	
<link
	href="/style/formattingFileShowingSchedule.css"
	type="text/css"
	rel="stylesheet">
	<title>EditShowingDateSelection</title>
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
		<h2>Create Showing</h2>
		<hr/>
		
		<form name="scheduleForm" action="/Showing Schedule/editShowingDisplay.php" method="post">
			<div class="wholeForm form-group">
				<label for="SAgent"><b>Enter/Select Showing Agent:</b></label>
				<input class="selectAgent" id="selectSAgent" name='SAgent' placeholder="Enter text here.." value="<?php echo $formatted_info[0];?>" required>
				<br/>
				
				<label for="date"><b>Date (MM/DD/YYYY):</b></label> 
				<input type="text" name="date" id="date" value="<?php echo $previous_data_array["date"]; ?>" required>
				<br>
				
				<label for="fname"><b>Customer First Name:</b></label>
				<input type="text" name="fname" value="<?php echo $previous_data_array["fname"]; ?>">
				<br>
				
				<label for="lname"><b>Customer Last Name:</b></label>
				<input type="text" name="lname" value="<?php echo $previous_data_array["lname"]; ?>">
				<br>
				
				<label for="code"><b>Lock Box Code:</b></label>
				<input type="text" name="code" value="<?php echo $previous_data_array["code"]; ?>">
				<br>
					
				<label for="occupy"><b>Is home occupied?</b></label>
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
				</select>
				<br/>
					<input type="hidden" name="showing_id" value="<?php echo $_GET['showing_id'];?>">
					<input type="hidden" name="MLS" value="<?php echo $_GET['MLS']; ?>">
					<input type="hidden" name="original_SA" value= "<?php echo $previous_data_array["SA_id"];?>">
				<br/>
				
				<input type="hidden" name="MLS" value="<?php echo $_GET['MLS']; ?>">
				<input class="button btn btn-default" type="submit" value="Submit" name="Submit" onClick="return isValid()"/>
			</div>
		</form>
	</div>
	<?php  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/footer.php"; ?>
</body>
</html>
