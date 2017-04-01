<html>
    <head>
		<title>Change Your Password</title>
    </head>
    <body>
        <?php include "header.php";?>
		<div class="container-fluid">
			<h2>
				Change Your Password
			</h2>
			<hr/>
			<form id="changepass" action="changepassresult.php" method="post">
				<input type='hidden' name='submitted' id='submitted' value='1'/>
				<?php
                    include "sessioncheck.php";
                    
                    //Resume session. If no session found,Let the user specify there username
					session_start();
					
                    //If the user is not logged in, provide a username field.
					if(!isset($_SESSION['name']))
					{
                        //Take them to the header instead.
                        header("./listings.php");
						//echo "<label for ='currentPass'>Username: </label>
						//<input type='text' name='username' id='currentPass' maxlength='25'/><br/>";
					} else {
						echo "Currently logged in as " . $_SESSION['name'] . "</br>";
					}
				?>

				<label for ='currentPass'>Current Password: </label>
				<input type='password' name='currentPass' id='currentPass' maxlength='25'/><br/>

				<label for='newPass' >New Password:</label>
				<input type='password' name='newPass' id='newPass' maxlength="25"/> <br/>

				<label for='updatedPass'>Confirm Password:</label>
				<input type='password' name='updatedPass' id='updatedPass' maxlength="25"/><br/>
				
				<input type='submit' name='Submit' value='Submit' /> <br/>
				<br/>
				<a href="./sessiontest.php" class="btn btn-default">
					Session Test
				</a> 
			</form>
		</div>
        <?php include "footer.php";?>
    </body>    
</html>
