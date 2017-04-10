 <!--Begin Delete Modal Window--> 
<script>
$(document).on("click", ".deleteShowingsButton", function () {
  var showing_id = $(this).data('id');
  var res = showing_id.split(" ");
  if(res[0] == 'A')
  {
    $('.modal-body #confirm').attr('href', '/Helpers/Showing Schedule/deleteShowingAgentHandle.php?showing_id=' + res[1]);
  }else
  {
    $('.modal-body #confirm').attr('href', '/Helpers/Showing Schedule/deleteShowingHandle.php?MLS=' + <?php if(isset($_GET['MLS'])){echo $_GET['MLS'];}else{echo'0';} ?> + '&showing_id=' + res[1]);
  }
  
});

$(document).on("click", ".deleteListingsButton", function () {
    var MLS = $(this).data('id');
    $('.modal-body #confirm').attr('href', '/Helpers/Listing/deleteListingHandle.php?MLS=' + MLS);
});
</script>

<div class="modal fade left" id="myDeleteModal"> 
    <div class="modal-dialog"> 
        <div class="modal-content"> 
            <div class="modal-header">
                <h3 class="pull-left no-margin">Are you sure you want to delete this showing?</h3>
                <button type="button" class="close" data-dismiss="modal" title="Close"><span class="glyphicon glyphicon-remove"></span>
                </button> 
            </div>
            <div class="modal-body">
                <a id="confirm" href="#" class="btn btn-default" type="button">Okay</a>
                <a class="btn btn-default" type="button" data-dismiss="modal">Cancel</a> 
            </div>
        </div> 
    </div> 
</div>
 <!--End Delete Modal Window--> 