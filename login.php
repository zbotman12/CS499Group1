<head>
	<style>
		a .btn .btn-default {
			display: inline;
			margin-bottom: 5px;
		}
	</style>
</head>
<body>
	<?php include "header.php"; ?>
	<!--http://www.html-form-guide.com/php-form/php-login-form.html-->
	<div class="container-fluid">
		<form id="login" action="landingpage.php" method="post">
		
			<h2>Login</h2>
			<hr/>
			<input type='hidden' name='submitted' id='submitted' value='1'/>
			
			<label for='username' >UserName:</label>
			<input type='text' name='username' id='username'  maxlength="50" autofocus/>
			<br/>

			<label for='password' >Password:</label>
			<input type='password' name='password' id='password' maxlength="25" />
			<br/>
			
			<input type='submit' name='Submit' value='Submit' />
		</form>
		<a href="./sessiontest.php" class="btn btn-default">
			Session Test
		</a>
		<a href="./changepass.php" class="btn btn-default">
			Change Password
		</a>
		<a href="./createagent.php" class="btn btn-default">
			Create New Agent
		</a>
	</div>
	<br/>
	<?php include "footer.php"; ?>
</body>