<html>

    <head><h1>Change your password</h1></head>
    <body>
        <form id="changepass" action="changepasstest.php" method="post">
            <input type='hidden' name='submitted' id='submitted' value='1'/>
            <?php
                //Resume session. If no session found,Let the user specify there username
                session_start();
                //If the user is not logged in, provide a username field.
                if(!isset($_SESSION['name']))
                {
                    echo "<label for ='currentPass'>Username: </label>
                    <input type='text' name='username' id='currentPass' maxlength='25'/><br/>";
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

            <a href="./logintest.php"> Login</a><br/>
            <a href="./logouttest.php"> Logout</a><br/>
            <a href="./sessiontest.php">Session test</a> <br/>
        </form>
    </body>    
</html>
