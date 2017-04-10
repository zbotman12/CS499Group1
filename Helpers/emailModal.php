<!-- Modal Window here -->
<div class="container">
<div class="row">

<!--Button trigger for modal--> 
<!-- <button type="button" class="btn btn-default paragon" data-toggle="modal" data-target="#myModal">Send Email</button> -->

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
<form id="sendEmail" class="form-horizontal" role="form" method="post" action="/Helpers/Mail/emailFormHandler.php "> 
    <span class="required">* Required</span> 
    <div class="form-group"> 
        <label for="name" class="col-sm-3 control-label">
        <span class="required">*</span> Name:</label> 
        <div class="col-sm-9"> 
        <input type="text" class="form-control" id="name" name="name" placeholder="First &amp; Last" required> 
        </div> 
    </div> 
    <div class="form-group"> 
        <label for="email" class="col-sm-3 control-label">
        <span class="required">*</span> Email: </label> 
        <div class="col-sm-9"> 
        <input type="email" class="form-control" id="email" name="email" placeholder="you@cs499Team1.com" required> 
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
    <input type="hidden" name="MLS_number" value=" <?php echo $_GET['MLS'];?>"><br><br>
<!--end Form-->
</form>
</div>

<div class="modal-footer"> 
<div class="col-xs-10 pull-left text-left text-muted"> 
<small><strong>Privacy Policy:</strong>
Please read our ParagonMLS privacy policy and terms of abuse.</small> 
</div> 
<button class="btn-sm close" type="button" data-dismiss="modal">Close</button> 

</div> 
</div> 
</div> 
</div>
</div> 
</div> 