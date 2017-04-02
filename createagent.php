<html>
    <!-- File: createagent.php
         Makes an agent entry in database.
    -->
    <head>
		<title>Create An Agent Account</title>
	</head>
    <body>
        <?php  include $_SERVER['DOCUMENT_ROOT'] . "/header.php" ?>

        <h2>Create An Agent Account</h2>

        <form id="createagent" action="/Helpers/createAgentHandle.php" method="post">
            <input type='hidden' name='submitted' id='submitted' value='1'/>
            
            <legend><b class="bold">Enter company information</b></legend>
            
            <label for="company_name">Company Name:</label>
            <input type='text' name='company_name' id='company_name' maxlength='100'/> <br/>

            <label for="address"> Company Address: </label>
            <input type='text' name='address' id='address' maxlength='100'/><br/>

            <label for='city'> City: </label>
            <input type='text' name='city' id='city' maxlength='45'/>
            
            <label for='state'> State: </label>
            <input type='text' name='state' id='state' maxlength='2'/>
            
            <label for='zip'> Zip: </label>
            <input type='text' name='zip' id='zip' maxlength='5'/> <br/>

            <label for="agency_phone_number">Phone Number: </label>
            <input type='text' name='agency_phone_number' id='agency_phone_number' maxlength='14'/> <br/> <br/>
            
            <legend><b class='bold'> Create your agent credentials</b></legend>
            
            <label for ='user_loginname'>Username: </label>
            <input type='text' name='user_login' id='user_login' maxlength='50'/><br/>

            <label for='password' >Create a password:</label>
            <input type='password' name='password' id='password' maxlength="25"/> <br/>

            <label for='confirm_pass'>Confirm Password:</label>
            <input type='password' name='confirm_pass' id='confirm_pass' maxlength="25"/><br/> <br/>

            <legend><b class='bold'>Enter your agent information</b></legend>
            
            <label for='first_name'> First name: </label>
            <input type="text" name="first_name" id='first_name' maxlength="50"/> <br/>

            <label for='last_name'> Last name: </label>
            <input type="text" name="last_name" id='last_name' maxlength="50"/><br/>

            <label for='email'> Email: </label>
            <input type='text' name='email' id='email' maxlength="255"/><br/>

            <label for='agent_phone_number'> Phone number:</label>
            <input type='text' name='agent_phone_number' id='agent_phone_number' maxlength="14"/><br/>

            <input type='submit' name='Submit' value='Submit' /> <br/>
        </form>

        <?php  include $_SERVER['DOCUMENT_ROOT'] . "/footer.php" ?>
    </body>    
</html>
