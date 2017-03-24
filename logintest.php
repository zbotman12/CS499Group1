<head>
</head>
<body>
	<!--http://www.html-form-guide.com/php-form/php-login-form.html-->
	<form id="login" action="landingpagetest.php" method="post">
	
		<legend>Login</legend>
		
		<input type='hidden' name='submitted' id='submitted' value='1'/>
		
		<label for='username' >UserName:</label>
		<input type='text' name='username' id='username'  maxlength="50" />
		<br/>

		<label for='password' >Password:</label>
		<input type='password' name='password' id='password' maxlength="25" />
		<br/>
		
		<input type='submit' name='Submit' value='Submit' />
	</form>
	<a href="./sessiontest.php">Session test</a> <br/>
	<a href="./logintest.php">Login</a><br/>
	<a href="./changepass.php">Change Password</a> <br/>
	<a href="./createagent.php">Create New Agent</a> <br/>
</body>
