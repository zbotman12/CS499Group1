<head>
	<title>Test</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$(".thousandChars").keyup(function(){
			  $(this).next().text("Characters remaining: " + (1000 - $(this).val().length));
			});
		});
	</script>
</head>
<body>
	<?php include "header.php"; ?>
	<div class="container-fluid">
			<textarea name="room_desc" rows="10" cols="30" class="thousandChars">
			</textarea>
			<p class="remainingChars">Characters remaining: 1000</p>
	</div>
	<?php include "footer.php"; ?>
</body>