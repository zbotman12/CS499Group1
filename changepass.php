<!-- 
    File: changepass.php
    Change password form.  
    Given an agent's username, communicates with database to update agent's password. 

-->
<!-- HTML code -->
<html>

    <head><h1>The hottest place to change your password</h1></head>
    <body>
        <form id="changepass" action="changepasstest.php" method="post">
            <input type='hidden' name='submitted' id='submitted' value='1'/>
            
            <label for ='currentPass'>Current Password: </label>
            <input type='password' name='currentPass' id='currentPass' maxlength='25'/><br/>

            <label for='newPass' >New Password:</label>
            <input type='password' name='newPass' id='newPass' maxlength="25"/> <br/>

            <label for='updatedPass'>Confirm Password:</label>
            <input type='password' name='updatedPass' id='updatedPass' maxlength="25"/><br/>
            
            <input type='submit' name='Submit' value='Submit' /> <br/>

            <a href="./logintest.php"> Login</a><br/>
            <a href="./changepass.php"> Change Your Password</a><br/>
        </form>
    </body>    
</html>
