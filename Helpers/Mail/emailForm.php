<!doctype html> 
<html> 
	<head> 
	<meta charset="utf-8"> 
	<title>Send email</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	
	<!--Files--> 
	<link href="../../style/bootstrap.min.css" rel="stylesheet">
    <link href="../../style/bootstrap.css" rel="stylesheet">
    <script src="../../js/jquery-1.11.3.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
	</head> 
	
	<body> 
		<div class="container">
		<div class="row">

		<!--Button trigger for modal--> 
		<button type="button" class="btn" data-toggle="modal" data-target="#myModal">Send Email</button>
		 
		<!--Begin Modal Window--> 
		<div class="modal fade left" id="myModal"> 
		<div class="modal-dialog"> 
		<div class="modal-content"> 
		<div class="modal-header"> 
		<h3 class="pull-left no-margin">Send message to agent</h3>
		<button type="button" class="close" data-dismiss="modal" title="Close"><span class="glyphicon glyphicon-remove"></span>
		</button> 
		</div> 

		<div class="modal-body">
			<!--Contact Form-->
			<form class="form-horizontal" role="form" method="post" action="emailFormHandler.php "> 
				<span class="required">* Required</span> 
				<div class="form-group"> 
					<label for="name" class="col-sm-3 control-label">
					<span class="required">*</span> Name:</label> 
					<div class="col-sm-9"> 
					<input type="text" class="form-control" id="name" name="name" placeholder="First & Last" required> 
					</div> 
				</div> 
				<div class="form-group"> 
					<label for="email" class="col-sm-3 control-label">
					<span class="required">*</span> Email: </label> 
					<div class="col-sm-9"> 
					<input type="email" class="form-control" id="email" name="email" placeholder="you@domain.com" required> 
					</div> 
				</div> 
				<div class="form-group"> 
					<label for="message" class="col-sm-3 control-label">
					<span class="required">*</span> Message:</label> 
					<div class="col-sm-9"> 
					<textarea name="message" rows="4" required class="form-control" id="message" placeholder="Comments"></textarea> 
					</div> 
				</div> 
				<div class="form-group"> 
					<div class="col-sm-offset-3 col-sm-6 col-sm-offset-3"> 
					<button type="submit" id="submit" name="submit" class="btn-lg btn-primary">Send</button> 
					</div> 
				</div>
				<input type="hidden" name = "showing_agent_id" value=" <?php echo 1;?>"><br><br>
			<!--end Form-->
			</form>
		</div>

		<div class="modal-footer"> 
		<div class="col-xs-10 pull-left text-left text-muted"> 
		<small><strong>Privacy Policy:</strong>
		Do not spam other agents or else you'll be destroyed.</small> 
		</div> 
		<button class="btn-sm close" type="button" data-dismiss="modal">Close</button> 
		</div> 
		</div> 
		</div> 
		</div>
		</div> 
		</div> 
	</body> 
</html>