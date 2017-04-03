<!--
    File: deleteListing.php
  Deletes the agents from database just given the MLS number.
-->

<?php
  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/sessioncheck.php";
  include $_SERVER['DOCUMENT_ROOT'] . "/Helpers/DBTransactor/DBTransactorFactory.php";

  function deleteListing() {
    $listings = DBTransactorFactory::build("Listings");
    
    //(Michael) :: Must update this to have MLS number from current session after clicking delete listing from agent session
    try {
      // Convert MLS_number from string to integer
      $mls = $_POST['MLS_number'];
      $mls= intval(str_replace(' ', '', $mls));
      
      //var_dump($mls);
      // Delete listing
      $listings->delete(["MLS_number" => $mls]);
	  echo "Listing successfuly deleted";
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }
?>

<?php  include $_SERVER['DOCUMENT_ROOT'] . "/header.php" ?>
<div class="container-fluid">
	<h2>Delete Listing</h2>
	<hr/>
	<?php deleteListing(); ?>
</div>
<br/>
<?php  include $_SERVER['DOCUMENT_ROOT'] . "/footer.php" ?>