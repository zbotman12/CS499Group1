<head>

	<script>
		function formListener() {
			console.log("Accepted");
		}
	</script>

</head>
<body>

	Username <input type="text" name="username"/> <br/>
	Password  <input type="text" name="password"/> <br/>
	<button onclick="formListener()"> Submit </button>
	
	<p name="response">
	
	<?php
		ob_start();
		include './loginscripttest.php';
		$result = ob_get_clean();
		echo $result;
	?>
	</p>

</body>