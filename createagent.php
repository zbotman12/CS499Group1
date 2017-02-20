<!-- 
    File: createagent.php
    Makes an agent entry in database.    
-->

<!-- HTML code -->
<html>

    <head><h1>Create an agent account</h1></head>
    <body>
        <form id="createagent" action="createagenttest.php" method="post">
            <input type='hidden' name='submitted' id='submitted' value='1'/>
            
            <legend><b class="bold">Enter company information</b></legend><br/>
            
            <label for="company_name">Company Name:</label>
            <input type='text' name='company_name' id='company_name' maxlength='100'/> <br/>

            <label for="company_address"> Address: </label>
            <input type='text' name='company_address' id='company_address' maxlength='100'/><br/>

            <label for='company_city'> City: </label>
            <input type='text' name='company_city' id='company_city' maxlength='45'/>
            <label for='company_state'> State: </label>
            <input type='text' name='company_state' id='company_state' maxlength='2'/>
            <label for='company_zip'> Zip: </label>
            <input type='text' name='company_zip' id='company_zip' maxlength='5'/> <br/>

            <label for="company_phone_number">Phone Number: </label>
            <input type='text' name='company_phone_number' id='company_phone_number' maxlength='14'/> <br/> <br/>
            
            <legend><b class='bold'> Create your agent credentials</b></legend> <br/>
            
            <label for ='username'>Username: </label>
            <input type='text' name='username' id='username' maxlength='50'/><br/>

            <label for='password' >Create a password:</label>
            <input type='password' name='password' id='password' maxlength="25"/> <br/>

            <label for='confirmPass'>Confirm Password:</label>
            <input type='password' name='confirmPass' id='confirmPass' maxlength="25"/><br/> <br/>

            <legend><b class='bold'>Enter your agent information</b></legend> <br/>
            
            <label for='firstname'> First name: </label>
            <input type="text" name="firstname" id='firstname' maxlength="50"/> <br/>

            <label for='lastname'> Last name: </label>
            <input type="text" name="lastname" id='lastname' maxlength="50"/><br/>

            <label for='email'> Email: </label>
            <input type='text' name='email' id='email' maxlength="255"/><br/>

            <label for='agent_phone_number'> Phone number:</label>
            <input type='text' name='agent_phone_number' id='agent_phone_number' maxlength="14"/><br/>

            <input type='submit' name='Submit' value='Submit' /> <br/>
            <a href="./logintest.php"> Login</a><br/>
            <a href="./changepass.php"> Change Your Password</a><br/>
        </form>
    </body>    
</html>
